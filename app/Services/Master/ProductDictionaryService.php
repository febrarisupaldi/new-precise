<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductDictionary\ProductDictionaryRepository;
use App\DTOs\Master\ProductDictionary\CreateProductDictionaryDTO;
use App\DTOs\Master\ProductDictionary\UpdateProductDictionaryDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductDictionaryService
{
    protected ProductDictionaryRepository $productDictionaryRepo;

    public function __construct(ProductDictionaryRepository $productDictionaryRepo)
    {
        $this->productDictionaryRepo = $productDictionaryRepo;
    }

    public function all(callable $callback): void
    {
        $this->productDictionaryRepo->stream($callback);
    }

    public function find(mixed $id): ?object
    {
        return $this->productDictionaryRepo->find($id)->first();
    }

    public function create(CreateProductDictionaryDTO $dto): mixed
    {
        $id = $this->productDictionaryRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductDictionary');
        }

        return $id;
    }

    public function update(int $id, UpdateProductDictionaryDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productDictionaryRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductDictionary not found', code: 404);
            }
            $this->productDictionaryRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productDictionaryRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductDictionary');
            }
        });
    }

    public function delete(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $exists = $this->productDictionaryRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductDictionary not found', code: 404);
            }
            $this->productDictionaryRepo->setAuditSession($data);
            $success = $this->productDictionaryRepo->delete($id);

            if ($success === false) {
                throw new Exception('Failed to delete Product Dictionary');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productDictionaryRepo->exists($conditions);
    }
}
