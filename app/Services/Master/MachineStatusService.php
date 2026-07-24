<?php

namespace App\Services\Master;


use App\Repositories\Master\MachineStatus\MachineStatusRepository;
use App\DTOs\Master\MachineStatus\CreateMachineStatusDTO;
use App\DTOs\Master\MachineStatus\UpdateMachineStatusDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class MachineStatusService
{
    protected MachineStatusRepository $machineStatusRepo;

    public function __construct(MachineStatusRepository $machineStatusRepo)
    {
        $this->machineStatusRepo = $machineStatusRepo;
    }

    public function all(): object
    {
        return $this->machineStatusRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->machineStatusRepo->find($id)->first();
    }

    public function create(CreateMachineStatusDTO $dto): mixed
    {
        $id = $this->machineStatusRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MachineStatus');
        }

        return $id;
    }

    public function update(int $id, UpdateMachineStatusDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->machineStatusRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MachineStatus not found', code: 404);
            }
            $this->machineStatusRepo->setAuditSession($dto->toAuditArray());
            $success = $this->machineStatusRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MachineStatus');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->machineStatusRepo->exists($dto->columns, $dto->values);
    }
}
