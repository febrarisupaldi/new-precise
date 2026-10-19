<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductItem\ProductItemRepository;
use App\DTOs\Master\ProductItem\CreateProductItemDTO;
use App\DTOs\Master\ProductItem\UpdateProductItemDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductItemService
{
    protected ProductItemRepository $productItemRepo;

    public function __construct(ProductItemRepository $productItemRepo)
    {
        $this->productItemRepo = $productItemRepo;
    }

    public function all(): object
    {
        return $this->productItemRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productItemRepo->find($id)->first();
    }

    public function create(CreateProductItemDTO $dto): mixed
    {
        $id = $this->productItemRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductItem');
        }

        return $id;
    }

    public function update(int $id, UpdateProductItemDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productItemRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductItem not found', code: 404);
            }
            $this->productItemRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productItemRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductItem');
            }
        });
    }

    public function delete(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $exists = $this->productItemRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductItem not found', code: 404);
            }
            $this->productItemRepo->setAuditSession($data);
            $success = $this->productItemRepo->delete($id);

            if ($success === false) {
                throw new Exception('Failed to delete ProductItem');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productItemRepo->exists($conditions);
    }
}
