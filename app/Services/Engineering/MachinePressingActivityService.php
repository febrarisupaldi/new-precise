<?php

namespace App\Services\Engineering;


use App\Repositories\Engineering\MachinePressingActivity\MachinePressingActivityRepository;
use App\DTOs\Engineering\MachinePressingActivity\CreateMachinePressingActivityDTO;
use App\DTOs\Engineering\MachinePressingActivity\UpdateMachinePressingActivityDTO;
use App\DTOs\Engineering\MoldPressingActivity\CreateMoldPressingActivityDTO;
use App\Exceptions\BadRequestException;
use App\Repositories\Engineering\MoldPressingActivity\MoldPressingActivityRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class MachinePressingActivityService
{
    protected MachinePressingActivityRepository $machinePressingActivityRepo;
    protected MoldPressingActivityRepository $moldPressingActivityRepo;

    public function __construct(MachinePressingActivityRepository $machinePressingActivityRepo, MoldPressingActivityRepository $moldPressingActivityRepo)
    {
        $this->machinePressingActivityRepo = $machinePressingActivityRepo;
        $this->moldPressingActivityRepo = $moldPressingActivityRepo;
    }

    public function all(array $filters): object
    {
        if (
            !isset($filters['trans_date']) &&
            !isset($filters['shift']) &&
            !isset($filters['location'])
        ) {
            throw new InvalidArgumentException("Invalid Arguments");
        }
        return $this->machinePressingActivityRepo->all($filters)->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->machinePressingActivityRepo->find($id)->first();
    }

    public function create(CreateMachinePressingActivityDTO $dto, CreateMoldPressingActivityDTO $mold_dto): mixed
    {
        return DB::transaction(function () use ($dto, $mold_dto) {
            $id = $this->machinePressingActivityRepo->insert($dto->toArray());
            $this->moldPressingActivityRepo->insert($mold_dto->toArray());

            if (!$id) {
                throw new Exception('Failed to create MachinePressingActivity');
            }
            return $id;
        });
    }

    public function update(int $id, UpdateMachinePressingActivityDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->machinePressingActivityRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MachinePressingActivity not found', code: 404);
            }
            $this->machinePressingActivityRepo->setAuditSession($dto->toAuditArray());
            $success = $this->machinePressingActivityRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MachinePressingActivity');
            }
        });
    }

    public function delete(int $id): int
    {
        $exists = $this->machinePressingActivityRepo->find($id)->first();

        if (!$exists) {
            throw new BadRequestException('MachinePressingActivity not found', code: 404);
        }
        return $this->machinePressingActivityRepo->delete($id);
    }

    public function checkExist(array $conditions): bool
    {
        return $this->machinePressingActivityRepo->exists($conditions);
    }
}
