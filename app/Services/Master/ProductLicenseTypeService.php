<?php

namespace App\Services\Master;


use App\Repositories\Master\ProductLicenseType\ProductLicenseTypeRepository;
use App\DTOs\Master\ProductLicenseType\CreateProductLicenseTypeDTO;
use App\DTOs\Master\ProductLicenseType\UpdateProductLicenseTypeDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductLicenseTypeService
{
    protected ProductLicenseTypeRepository $productLicenseTypeRepo;

    public function __construct(ProductLicenseTypeRepository $productLicenseTypeRepo)
    {
        $this->productLicenseTypeRepo = $productLicenseTypeRepo;
    }

    public function all(): object
    {
        return $this->productLicenseTypeRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->productLicenseTypeRepo->find($id)->first();
    }

    public function create(CreateProductLicenseTypeDTO $dto): mixed
    {
        $id = $this->productLicenseTypeRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ProductLicenseType');
        }

        return $id;
    }

    public function update(int $id, UpdateProductLicenseTypeDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->productLicenseTypeRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ProductLicenseType not found', code: 404);
            }
            $this->productLicenseTypeRepo->setAuditSession($dto->toAuditArray());
            $success = $this->productLicenseTypeRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ProductLicenseType');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->productLicenseTypeRepo->exists($conditions);
    }
}
