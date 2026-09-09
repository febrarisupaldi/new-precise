<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductType\ProductTypeRepository;
use App\DTOs\Master\ProductType\CreateProductTypeDTO;
use App\DTOs\Master\ProductType\UpdateProductTypeDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductTypeService
{
    protected ProductTypeRepository $productTypeRepo;

    public function __construct(ProductTypeRepository $productTypeRepo)
    {
        $this->productTypeRepo = $productTypeRepo;
    }

    public function all(): object
    {
        return $this->productTypeRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productTypeRepo->find($id)->first();
    }

    public function create(CreateProductTypeDTO $dto): mixed
    {
        $id = $this->productTypeRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductType');
        }

        return $id;
    }

    public function update(int $id, UpdateProductTypeDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productTypeRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductType not found', code: 404);
            }
            $this->productTypeRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productTypeRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductType');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productTypeRepo->exists($conditions);
    }
}
