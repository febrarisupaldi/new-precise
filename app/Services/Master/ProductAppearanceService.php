<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductAppearance\ProductAppearanceRepository;
use App\DTOs\Master\ProductAppearance\CreateProductAppearanceDTO;
use App\DTOs\Master\ProductAppearance\UpdateProductAppearanceDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductAppearanceService
{
    protected ProductAppearanceRepository $productAppearanceRepo;

    public function __construct(ProductAppearanceRepository $productAppearanceRepo)
    {
        $this->productAppearanceRepo = $productAppearanceRepo;
    }

    public function all(): object
    {
        return $this->productAppearanceRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productAppearanceRepo->find($id)->first();
    }

    public function create(CreateProductAppearanceDTO $dto): mixed
    {
        $id = $this->productAppearanceRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductAppearance');
        }

        return $id;
    }

    public function update(int $id, UpdateProductAppearanceDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productAppearanceRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductAppearance not found', code: 404);
            }
            $this->productAppearanceRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productAppearanceRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductAppearance');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productAppearanceRepo->exists($conditions);
    }
}
