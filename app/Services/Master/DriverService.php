<?php

namespace App\Services\Master;


use App\Repositories\Master\Driver\DriverRepository;
use App\DTOs\Master\Driver\{CreateDriverDTO, UpdateDriverDTO};
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class DriverService
{
    protected DriverRepository $driverRepo;

    public function __construct(DriverRepository $driverRepo)
    {
        $this->driverRepo = $driverRepo;
    }

    public function all(): object
    {
        return $this->driverRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->driverRepo->find($id)->first();
    }

    public function create(CreateDriverDTO $dto): mixed
    {
        $id = $this->driverRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Driver');
        }

        return $id;
    }

    public function update(int $id, UpdateDriverDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->driverRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Driver not found', code: 404);
            }
            $this->driverRepo->setAuditSession($dto->toAuditArray());
            $success = $this->driverRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Driver');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->driverRepo->exists($conditions);
    }
}
