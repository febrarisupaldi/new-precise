<?php

namespace App\Services\Master;


use App\DTOs\Master\Product\CreateProductDTO;
use App\DTOs\Master\Product\UpdateProductDTO;
use App\Exceptions\BadRequestException;
use App\Repositories\Master\Product\ProductRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected ProductRepository $productRepo;

    public function __construct(ProductRepository $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function stream(callable $callback): bool
    {
        return $this->productRepo->stream($callback);
    }

    public function find(mixed $id): ?object
    {
        return $this->productRepo->find($id)->first();
    }

    public function create(CreateProductDTO $dto): mixed
    {
        $id = $this->productRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Product');
        }

        return $id;
    }

    public function update(int $id, UpdateProductDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Product not found', code: 404);
            }
            $this->productRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Product');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productRepo->exists($conditions);
    }
}
