<?php

namespace App\Services\Master\City;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\City\CityRepository;
use App\DTOs\Master\City\CreateCityDTO;
use App\DTOs\Master\City\UpdateCityDTO;
use Illuminate\Support\Facades\DB;

class CityService
{
    protected $cityRepo;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepo = $cityRepo;
    }

    public function all(): array
    {
        return [
            "status" => "ok",
            "data" => $this->cityRepo->all()->get()
        ];
    }

    public function find(int $id): array
    {
        return [
            "status" => "ok",
            "data" => $this->cityRepo->find($id)->first()
        ];
    }

    public function create(CreateCityDTO $dto): array
    {
        $success = $this->cityRepo->create($dto->toArray());

        return [
            'status' => $success ? 'ok' : 'error',
            'message' => $success ? 'City created successfully.' : 'Failed to create City.',
        ];
    }

    public function update(int $id, UpdateCityDTO $dto): array
    {
        return DB::transaction(function () use ($id, $dto) {
            $exists = $this->cityRepo->find($id)->first();

            if (!$exists) {
                return ['success' => false, 'message' => 'City not found.'];
            }
            $this->cityRepo->setAuditSession($dto->toAuditArray());
            $affected = $this->cityRepo->update($id, $dto->withoutAuditArray());

            return [
                'success' => $affected >= 0,
                'message' => 'City updated successfully.',
            ];
        });
    }

    public function checkExist(ExistsDTO $dto): array
    {
        $exists = $this->cityRepo->exists($dto->columns, $dto->values);

        return [
            'success' => $exists,
            'message' => $exists ? 'City already exists.' : 'City not found.',
        ];
    }
}
