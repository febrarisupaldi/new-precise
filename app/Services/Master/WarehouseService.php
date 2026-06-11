<?php

namespace App\Services\Master;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\Warehouse\WarehouseRepository;
use App\DTOs\Master\Warehouse\CreateWarehouseDTO;
use App\DTOs\Master\Warehouse\UpdateWarehouseDTO;
use App\Exceptions\BadRequestException;
use Exception;
use App\DTOs\Traits\AuditDTO;
use Illuminate\Support\Facades\DB;

class WarehouseService
{

    use AuditDTO;
    protected WarehouseRepository $warehouseRepo;

    public function __construct(WarehouseRepository $warehouseRepo)
    {
        $this->warehouseRepo = $warehouseRepo;
    }

    public function all(?array $filter = null): object
    {
        return $this->warehouseRepo->all($filter)->get();
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
            $success = $this->warehouseRepo->delete($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Warehouse');
            }
        });
    }

    public function delete(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $exists = $this->warehouseRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Warehouse not found', code: 404);
            }
            $this->warehouseRepo->setAuditSession($data);
            $success = $this->warehouseRepo->delete($id, $data);

            if ($success === false) {
                throw new Exception('Failed to delete Warehouse');
            }
        });
    }
    

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->warehouseRepo->exists($dto->columns, $dto->values);
    }
}
