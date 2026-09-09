<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductSeries\ProductSeriesRepository;
use App\DTOs\Master\ProductSeries\CreateProductSeriesDTO;
use App\DTOs\Master\ProductSeries\UpdateProductSeriesDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductSeriesService
{
    protected ProductSeriesRepository $productSeriesRepo;

    public function __construct(ProductSeriesRepository $productSeriesRepo)
    {
        $this->productSeriesRepo = $productSeriesRepo;
    }

    public function all(): object
    {
        return $this->productSeriesRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productSeriesRepo->find($id)->first();
    }

    public function create(CreateProductSeriesDTO $dto): mixed
    {
        $id = $this->productSeriesRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductSeries');
        }

        return $id;
    }

    public function update(int $id, UpdateProductSeriesDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productSeriesRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductSeries not found', code: 404);
            }
            $this->productSeriesRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productSeriesRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductSeries');
            }
        });
    }

    public function delete(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $exists = $this->productSeriesRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ColorType not found', code: 404);
            }
            $this->productSeriesRepo->setAuditSession($data);
            $success = $this->productSeriesRepo->delete($id);

            if ($success === false) {
                throw new Exception('Failed to delete ColorType');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productSeriesRepo->exists($conditions);
    }
}
