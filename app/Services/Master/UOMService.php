<?php

namespace App\Services\Master;


use App\Repositories\Master\UOM\UOMRepository;
use App\DTOs\Master\UOM\CreateUOMDTO;
use App\DTOs\Master\UOM\UpdateUOMDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class UOMService
{
    protected UOMRepository $UOMRepo;

    public function __construct(UOMRepository $UOMRepo)
    {
        $this->UOMRepo = $UOMRepo;
    }

    public function all(): object
    {
        return $this->UOMRepo->all()->get();
    }

    public function find(mixed $id): ?object
    {
        return $this->UOMRepo->find($id)->first();
    }

    public function create(CreateUOMDTO $dto): mixed
    {
        $id = $this->UOMRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create UOM');
        }

        return $id;
    }

    public function update(int $id, UpdateUOMDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->UOMRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('UOM not found', code: 404);
            }
            $this->UOMRepo->setAuditSession($dto->toAuditArray());
            $success = $this->UOMRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update UOM');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->UOMRepo->exists($dto->columns, $dto->values);
    }
}
