<?php

namespace App\Services\Master;


use App\Repositories\Master\RetailType\RetailTypeRepository;
use App\DTOs\Master\RetailType\CreateRetailTypeDTO;
use App\DTOs\Master\RetailType\UpdateRetailTypeDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class RetailTypeService
{
    protected RetailTypeRepository $retailTypeRepo;

    public function __construct(RetailTypeRepository $retailTypeRepo)
    {
        $this->retailTypeRepo = $retailTypeRepo;
    }

    public function all(): object
    {
        return $this->retailTypeRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->retailTypeRepo->find($id)->first();
    }

    public function create(CreateRetailTypeDTO $dto): mixed
    {
        $id = $this->retailTypeRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create RetailType');
        }

        return $id;
    }

    public function update(int $id, UpdateRetailTypeDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->retailTypeRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('RetailType not found', code: 404);
            }
            $this->retailTypeRepo->setAuditSession($dto->toAuditArray());
            $success = $this->retailTypeRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update RetailType');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->retailTypeRepo->exists($conditions);
    }
}
