<?php

namespace App\Services\Master;


use App\Repositories\Master\MachinePressing\MachinePressingRepository;
use App\DTOs\Master\MachinePressing\CreateMachinePressingDTO;
use App\DTOs\Master\MachinePressing\UpdateMachinePressingDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class MachinePressingService
{
    protected MachinePressingRepository $machinePressingRepo;

    public function __construct(MachinePressingRepository $machinePressingRepo)
    {
        $this->machinePressingRepo = $machinePressingRepo;
    }

    public function all(?array $filters = []): object
    {
        return $this->machinePressingRepo->all($filters)->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->machinePressingRepo->find($id)->first();
    }

    public function create(CreateMachinePressingDTO $dto): mixed
    {
        $id = $this->machinePressingRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MachinePressing');
        }

        return $id;
    }

    public function update(int $id, UpdateMachinePressingDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->machinePressingRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MachinePressing not found', code: 404);
            }
            $this->machinePressingRepo->setAuditSession($dto->toAuditArray());
            $success = $this->machinePressingRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MachinePressing');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->machinePressingRepo->exists($conditions);
    }
}
