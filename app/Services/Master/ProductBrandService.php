<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductBrand\ProductBrandRepository;
use App\DTOs\Master\ProductBrand\CreateProductBrandDTO;
use App\DTOs\Master\ProductBrand\UpdateProductBrandDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductBrandService
{
    protected ProductBrandRepository $productBrandRepo;

    public function __construct(ProductBrandRepository $productBrandRepo)
    {
        $this->productBrandRepo = $productBrandRepo;
    }

    public function all(): object
    {
        return $this->productBrandRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productBrandRepo->find($id)->first();
    }

    public function create(CreateProductBrandDTO $dto): mixed
    {
        $id = $this->productBrandRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductBrand');
        }

        return $id;
    }

    public function update(int $id, UpdateProductBrandDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productBrandRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductBrand not found', code: 404);
            }
            $this->productBrandRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productBrandRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductBrand');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productBrandRepo->exists($conditions);
    }
}
