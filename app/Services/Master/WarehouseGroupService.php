<?php

namespace App\Services\Master;


use App\Repositories\Master\WarehouseGroup\WarehouseGroupRepository;
use App\DTOs\Master\WarehouseGroup\CreateWarehouseGroupDTO;
use App\DTOs\Master\WarehouseGroup\UpdateWarehouseGroupDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class WarehouseGroupService
{
    protected WarehouseGroupRepository $warehouseGroupRepo;

    public function __construct(WarehouseGroupRepository $warehouseGroupRepo)
    {
        $this->warehouseGroupRepo = $warehouseGroupRepo;
    }

    public function all(): object
    {
        return $this->warehouseGroupRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->warehouseGroupRepo->find($id)->first();
    }

    public function create(CreateWarehouseGroupDTO $dto): mixed
    {
        $id = $this->warehouseGroupRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create WarehouseGroup');
        }

        return $id;
    }

    public function update(int $id, UpdateWarehouseGroupDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->warehouseGroupRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('WarehouseGroup not found', code: 404);
            }
            $this->warehouseGroupRepo->setAuditSession($dto->toAuditArray());
            $success = $this->warehouseGroupRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update WarehouseGroup');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->warehouseGroupRepo->exists($dto->columns, $dto->values);
    }
}
