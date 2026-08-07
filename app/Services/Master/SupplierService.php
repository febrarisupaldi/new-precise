<?php

namespace App\Services\Master;


use App\Repositories\Master\Supplier\SupplierRepository;
use App\DTOs\Master\Supplier\CreateSupplierDTO;
use App\DTOs\Master\Supplier\UpdateSupplierDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class SupplierService
{
    protected SupplierRepository $supplierRepo;

    public function __construct(SupplierRepository $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function all(): object
    {
        return $this->supplierRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->supplierRepo->find($id)->first();
    }

    public function create(CreateSupplierDTO $dto): mixed
    {
        $id = $this->supplierRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Supplier');
        }

        return $id;
    }

    public function update(int $id, UpdateSupplierDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->supplierRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Supplier not found', code: 404);
            }
            $this->supplierRepo->setAuditSession($dto->toAuditArray());
            $success = $this->supplierRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Supplier');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->supplierRepo->exists($conditions);
    }
}
