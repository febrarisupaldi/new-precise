<?php

namespace App\Services\Master;


use App\Repositories\Master\MoldInjection\MoldInjectionRepository;
use App\DTOs\Master\MoldInjection\CreateMoldInjectionDTO;
use App\DTOs\Master\MoldInjection\UpdateMoldInjectionDTO;
use App\Exceptions\BadRequestException;
use App\Repositories\Master\MoldInjection\MoldInjectionDetailCavityRepository;
use App\Repositories\Master\MoldInjection\MoldInjectionDetailRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class MoldInjectionService
{
    protected MoldInjectionRepository $moldInjectionRepo;
    protected MoldInjectionDetailRepository $moldInjectionDetailRepo;
    protected MoldInjectionDetailCavityRepository $moldInjectionDetailCavityRepo;

    public function __construct(MoldInjectionRepository $moldInjectionRepo, MoldInjectionDetailRepository $moldInjectionDetailRepo, MoldInjectionDetailCavityRepository $moldInjectionDetailCavityRepo)
    {
        $this->moldInjectionRepo = $moldInjectionRepo;
        $this->moldInjectionDetailRepo = $moldInjectionDetailRepo;
        $this->moldInjectionDetailCavityRepo = $moldInjectionDetailCavityRepo;
    }

    public function all(): object
    {
        return $this->moldInjectionRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        $master = $this->moldInjectionRepo->find($id)->first();

        if (empty($master)) {
            return null;
        }

        $details = $this->moldInjectionDetailRepo->showByMasterID($id)->get();

        foreach ($details as $detail) {
            $cavities = $this->moldInjectionDetailCavityRepo->showByDetailID($detail->mold_injection_dt_id)->get();
            $detail->cavities = $cavities;
        }

        $master->details = $details;
        return $master;
    }

    public function create(CreateMoldInjectionDTO $dto): mixed
    {
        return DB::transaction(function () use ($dto) {
            $id = $this->moldInjectionRepo->insert($dto->except(['details']));

            $details = $dto->details;
            foreach ($details as $detail) {
                $detail = $detail->withMoldInjectionId($id);
                $detailID = $this->moldInjectionDetailRepo->insert($detail->except(['cavities']));

                $cavities = $detail->cavities;
                foreach ($cavities as $cavity) {
                    $cavity = $cavity->withMoldInjectionDetailId($detailID);

                    $this->moldInjectionDetailCavityRepo->insert($cavity->toArray());
                }
            }
        }, 3);
    }

    public function update(int $id, UpdateMoldInjectionDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->moldInjectionRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MoldInjection not found', code: 404);
            }
            $this->moldInjectionRepo->setAuditSession($dto->toAuditArray());
            $success = $this->moldInjectionRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MoldInjection');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->moldInjectionRepo->exists($conditions);
    }
}
