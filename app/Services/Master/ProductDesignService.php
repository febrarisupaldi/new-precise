<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductDesign\ProductDesignRepository;
use App\DTOs\Master\ProductDesign\CreateProductDesignDTO;
use App\DTOs\Master\ProductDesign\UpdateProductDesignDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductDesignService
{
    protected ProductDesignRepository $productDesignRepo;

    public function __construct(ProductDesignRepository $productDesignRepo)
    {
        $this->productDesignRepo = $productDesignRepo;
    }

    public function all(): object
    {
        return $this->productDesignRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productDesignRepo->find($id)->first();
    }

    public function create(CreateProductDesignDTO $dto): mixed
    {
        $id = $this->productDesignRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductDesign');
        }

        return $id;
    }

    public function update(int $id, UpdateProductDesignDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productDesignRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductDesign not found', code: 404);
            }
            $this->productDesignRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productDesignRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductDesign');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productDesignRepo->exists($conditions);
    }
}
