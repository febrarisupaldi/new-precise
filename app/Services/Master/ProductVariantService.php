<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductVariant\ProductVariantRepository;
use App\DTOs\Master\ProductVariant\CreateProductVariantDTO;
use App\DTOs\Master\ProductVariant\UpdateProductVariantDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductVariantService
{
    protected ProductVariantRepository $productVariantRepo;

    public function __construct(ProductVariantRepository $productVariantRepo)
    {
        $this->productVariantRepo = $productVariantRepo;
    }

    public function all(): object
    {
        return $this->productVariantRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productVariantRepo->find($id)->first();
    }

    public function create(CreateProductVariantDTO $dto): mixed
    {
        $id = $this->productVariantRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductVariant');
        }

        return $id;
    }

    public function update(int $id, UpdateProductVariantDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productVariantRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductVariant not found', code: 404);
            }
            $this->productVariantRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productVariantRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductVariant');
            }
        });
    }

    public function delete(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $exists = $this->productVariantRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductVariant not found', code: 404);
            }
            $this->productVariantRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productVariantRepo->delete($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to delete ProductVariant');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productVariantRepo->exists($conditions);
    }
}
