<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductGroup\ProductGroupRepository;
use App\DTOs\Master\ProductGroup\CreateProductGroupDTO;
use App\DTOs\Master\ProductGroup\UpdateProductGroupDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductGroupService
{
    protected ProductGroupRepository $productGroupRepo;

    public function __construct(ProductGroupRepository $productGroupRepo)
    {
        $this->productGroupRepo = $productGroupRepo;
    }

    public function all(): object
    {
        return $this->productGroupRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productGroupRepo->find($id)->first();
    }

    public function create(CreateProductGroupDTO $dto): mixed
    {
        $id = $this->productGroupRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductGroup');
        }

        return $id;
    }

    public function update(int $id, UpdateProductGroupDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productGroupRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductGroup not found', code: 404);
            }
            $this->productGroupRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productGroupRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductGroup');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productGroupRepo->exists($conditions);
    }
}
