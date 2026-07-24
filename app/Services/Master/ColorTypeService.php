<?php

namespace App\Services\Master;


use App\Repositories\Master\ColorType\ColorTypeRepository;
use App\DTOs\Master\ColorType\CreateColorTypeDTO;
use App\DTOs\Master\ColorType\UpdateColorTypeDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class ColorTypeService
{
    protected ColorTypeRepository $colorTypeRepo;

    public function __construct(ColorTypeRepository $colorTypeRepo)
    {
        $this->colorTypeRepo = $colorTypeRepo;
    }

    public function all(): object
    {
        return $this->colorTypeRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->colorTypeRepo->find($id)->first();
    }

    public function create(CreateColorTypeDTO $dto): mixed
    {
        $id = $this->colorTypeRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create ColorType');
        }

        return $id;
    }

    public function update(int $id, UpdateColorTypeDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->colorTypeRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ColorType not found', code: 404);
            }
            $this->colorTypeRepo->setAuditSession($dto->toAuditArray());
            $success = $this->colorTypeRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update ColorType');
            }
        });
    }

    public function delete(int $id, array $data): void
    {
        DB::transaction(function () use ($id, $data) {
            $exists = $this->colorTypeRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('ColorType not found', code: 404);
            }
            $this->colorTypeRepo->setAuditSession($data);
            $success = $this->colorTypeRepo->delete($id, $data);

            if ($success === false) {
                throw new Exception('Failed to delete ColorType');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->colorTypeRepo->exists($dto->columns, $dto->values);
    }
}
