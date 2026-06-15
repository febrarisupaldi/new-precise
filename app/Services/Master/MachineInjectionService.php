<?php

namespace App\Services\Master;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\MachineInjection\MachineInjectionRepository;
use App\DTOs\Master\MachineInjection\CreateMachineInjectionDTO;
use App\DTOs\Master\MachineInjection\UpdateMachineInjectionDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class MachineInjectionService
{
    protected MachineInjectionRepository $machineInjectionRepo;

    public function __construct(MachineInjectionRepository $machineInjectionRepo)
    {
        $this->machineInjectionRepo = $machineInjectionRepo;
    }

    public function all(): object
    {
        return $this->machineInjectionRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->machineInjectionRepo->find($id)->first();
    }

    public function create(CreateMachineInjectionDTO $dto): mixed
    {
        $id = $this->machineInjectionRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MachineInjection');
        }

        return $id;
    }

    public function update(int $id, UpdateMachineInjectionDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->machineInjectionRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MachineInjection not found', code: 404);
            }
            $this->machineInjectionRepo->setAuditSession($dto->toAuditArray());
            $success = $this->machineInjectionRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MachineInjection');
            }
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->machineInjectionRepo->exists($dto->columns, $dto->values);
    }
}
