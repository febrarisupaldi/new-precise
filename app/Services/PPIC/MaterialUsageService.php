<?php

namespace App\Services\PPIC;


use App\Repositories\PPIC\MaterialUsage\MaterialUsageRepository;
use App\DTOs\PPIC\MaterialUsage\CreateMaterialUsageDTO;
use App\DTOs\PPIC\MaterialUsage\UpdateMaterialUsageDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class MaterialUsageService
{
    protected MaterialUsageRepository $materialUsageRepo;

    public function __construct(MaterialUsageRepository $materialUsageRepo)
    {
        $this->materialUsageRepo = $materialUsageRepo;
    }

    public function all(): object
    {
        return $this->materialUsageRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->materialUsageRepo->find($id)->first();
    }

    public function create(CreateMaterialUsageDTO $dto): mixed
    {
        $id = $this->materialUsageRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create MaterialUsage');
        }

        return $id;
    }

    public function update(int $id, UpdateMaterialUsageDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->materialUsageRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('MaterialUsage not found', code: 404);
            }
            $this->materialUsageRepo->setAuditSession($dto->toAuditArray());
            $success = $this->materialUsageRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update MaterialUsage');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->materialUsageRepo->exists($conditions);
    }
}
