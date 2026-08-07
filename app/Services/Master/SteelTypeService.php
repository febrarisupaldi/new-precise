<?php

namespace App\Services\Master;


use App\Repositories\Master\SteelType\SteelTypeRepository;
use App\DTOs\Master\SteelType\CreateSteelTypeDTO;
use App\DTOs\Master\SteelType\UpdateSteelTypeDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class SteelTypeService
{
    protected SteelTypeRepository $steelTypeRepo;

    public function __construct(SteelTypeRepository $steelTypeRepo)
    {
        $this->steelTypeRepo = $steelTypeRepo;
    }

    public function all(): object
    {
        return $this->steelTypeRepo->all()->get();
    }

    public function find(mixed $id): object
    {
        $data = $this->steelTypeRepo->find($id)->first();
        if (!$data) {
            throw new BadRequestException('Steel Type not found.', code: 404);
        }

        return $data;
    }

    public function create(CreateSteelTypeDTO $dto): int
    {
        $id = $this->steelTypeRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create Steel Type', code: 400);
        }

        return $id;
    }

    public function update(mixed $id, UpdateSteelTypeDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->steelTypeRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Steel Type not found', code: 404);
            }
            $this->steelTypeRepo->setAuditSession($dto->toAuditArray());
            $success = $this->steelTypeRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update Steel Type');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->steelTypeRepo->exists($conditions);
    }
}
