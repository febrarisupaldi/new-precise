<?php

namespace App\Services\Master;


use App\Repositories\Master\CostCenter\CostCenterRepository;
use App\DTOs\Master\CostCenter\CreateCostCenterDTO;
use App\DTOs\Master\CostCenter\UpdateCostCenterDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class CostCenterService
{
    protected CostCenterRepository $costCenterRepo;

    public function __construct(CostCenterRepository $costCenterRepo)
    {
        $this->costCenterRepo = $costCenterRepo;
    }

    public function all(): object
    {
        return $this->costCenterRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->costCenterRepo->find($id)->first();
    }

    public function create(CreateCostCenterDTO $dto): mixed
    {
        $id = $this->costCenterRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create CostCenter');
        }

        return $id;
    }

    public function update(int $id, UpdateCostCenterDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->costCenterRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('CostCenter not found', code: 404);
            }
            $this->costCenterRepo->setAuditSession($dto->toAuditArray());
            $success = $this->costCenterRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update CostCenter');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->costCenterRepo->exists($conditions);
    }
}
