<?php

namespace App\Services\Master;


use App\DTOs\Master\Packaging\CreatePackagingDTO;
use App\DTOs\Master\Packaging\UpdatePackagingDTO;
use App\Repositories\Master\Packaging\PackagingRepository;
use App\Exceptions\BadRequestException;
use App\Repositories\Master\Packaging\PackagingDetailRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class PackagingService
{
    protected PackagingRepository $packagingRepo;
    protected PackagingDetailRepository $packagingDetailRepo;

    public function __construct(PackagingRepository $packagingRepo, PackagingDetailRepository $packagingDetailRepo)
    {
        $this->packagingRepo = $packagingRepo;
        $this->packagingDetailRepo = $packagingDetailRepo;
    }

    public function all(?array $filters = null): object
    {
        return $this->packagingRepo->all($filters)->get();
    }

    public function allWithDetails(): object
    {
        return $this->packagingRepo->allWithDetails()->get();
    }

    public function find(int $id): ?object
    {
        $data = $this->packagingRepo->show($id)->first();
        if (!$data) {
            throw new BadRequestException('Packaging not found.', code: 404);
        }

        $details = $this->packagingDetailRepo->findByHeaderID($id)->get();
        $data->details = $details;
        return $data;
    }

    public function create(CreatePackagingDTO $dto): void
    {
        DB::transaction(function () use ($dto) {
            $this->packagingRepo->insert($dto->except(['details']));
            $id = $dto->packaging_id;

            if ($dto->details != null) {
                $details = collect($dto->details)
                    ->map(function ($detail) use ($id) {
                        $row = $detail->toArray();
                        $row['packaging_id'] = $id;

                        return $row;
                    })
                    ->toArray();

                $this->packagingDetailRepo->insertBatch($details);
            }
        }, 3);
    }

    public function update(int $id, UpdatePackagingDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->packagingRepo->lock($id);

            if (!$exists) {
                throw new BadRequestException('Packaging not found', code: 404);
            }
            $this->packagingRepo->setAuditSession($dto->toAuditArray());

            $this->packagingRepo->update($id, $dto->except(['details', 'reason']));

            $existing = $this->packagingDetailRepo->findByHeaderID($id)->get();

            $incomingWithId = collect($dto->details)
                ->filter(fn($detail) => !empty($detail->packaging_dt_id))
                ->keyBy(fn($detail) => $detail->packaging_dt_id);


            $incomingNew = collect($dto->details)
                ->filter(fn($detail) => empty($detail->packaging_dt_id));

            $deleteIds = collect($existing)
                ->pluck('packaging_dt_id')
                ->diff($incomingWithId->keys())
                ->values()
                ->toArray();



            if (!empty($deleteIds)) {
                $this->packagingDetailRepo->bulkDeleteDetails($deleteIds);
            }

            $updateRows = $incomingWithId
                ->map(fn($detail) => [
                    "packaging_dt_id" => $detail->packaging_dt_id,
                    "product_id" => $detail->product_id,
                    "item_id" => $detail->item_id,
                    "item_code" => $detail->item_code,
                    "product_qty" => $detail->product_qty,
                    "priority" => $detail->priority,
                    "usage_per_unit" => $detail->usage_per_unit,
                    "updated_by" => $dto->updated_by,
                ])
                ->values()
                ->toArray();



            if (!empty($updateRows)) {
                $this->packagingDetailRepo->bulkUpdateDetails($updateRows);
            }

            $insertRows = $incomingNew
                ->map(fn($detail) => [
                    "packaging_id" => $id,
                    "product_id" => $detail->product_id,
                    "item_id" => $detail->item_id,
                    "item_code" => $detail->item_code,
                    "product_qty" => $detail->product_qty,
                    "priority" => $detail->priority,
                    "usage_per_unit" => $detail->usage_per_unit,
                    "updated_by" => $dto->updated_by,
                ])
                ->values()
                ->toArray();

            if (!empty($insertRows)) {
                $this->packagingDetailRepo->insertBatch($insertRows);
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->packagingRepo->exists($dto->columns, $dto->values);
    }
}
