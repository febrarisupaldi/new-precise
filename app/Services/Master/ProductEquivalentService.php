<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductEquivalent\ProductEquivalentRepository;
use App\DTOs\Master\ProductEquivalent\CreateProductEquivalentDTO;
use App\DTOs\Master\ProductEquivalent\UpdateProductEquivalentDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductEquivalentService
{
    protected ProductEquivalentRepository $productEquivalentRepo;

    public function __construct(ProductEquivalentRepository $productEquivalentRepo)
    {
        $this->productEquivalentRepo = $productEquivalentRepo;
    }

    public function all(): object
    {
        return $this->productEquivalentRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productEquivalentRepo->find($id)->first();
    }

    public function findByProductCode(string $productCode): ?object
    {
        return $this->productEquivalentRepo->findByProductCode($productCode)->get();
    }

    public function create(CreateProductEquivalentDTO $dto): mixed
    {
        $id = $this->productEquivalentRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductEquivalen');
        }

        return $id;
    }

    public function update(int $id, UpdateProductEquivalentDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productEquivalentRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Product Equivalen not found', code: 404);
            }
            $this->productEquivalentRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productEquivalentRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductEquivalen');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productEquivalentRepo->exists($dto->columns, $dto->values);
    }
}
