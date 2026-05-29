<?php

namespace App\Services\Master;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\Warehouse\WarehouseRepository;
use App\DTOs\Master\Warehouse\CreateWarehouseDTO;
use App\DTOs\Master\Warehouse\UpdateWarehouseDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class WarehouseService
{
    protected WarehouseRepository $warehouseRepo;

    public function __construct(WarehouseRepository $warehouseRepo)
    {
        $this->warehouseRepo = $warehouseRepo;
    }

    public function all(): object
    {
        return $this->warehouseRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->warehouseRepo->find($id)->first();
    }

    public function create(CreateWarehouseDTO $dto): mixed
    {
        $id = $this->warehouseRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Warehouse');
        }

        return $id;
    }

    public function update(int $id, UpdateWarehouseDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->warehouseRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Warehouse not found', code: 404);
            }
            $this->warehouseRepo->setAuditSession($dto->toAuditArray());
            $success = $this->warehouseRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Warehouse');
            }
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->warehouseRepo->exists($dto->columns, $dto->values);
    }
}
