<?php

namespace App\Services\Master\City;

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

    public function getAll()
    {
        return $this->cityRepo->all();
    }

    public function getById(int $id)
    {
        return $this->cityRepo->findById($id);
    }

    public function create(CreateCityDTO $dto): array
    {
        $success = $this->cityRepo->create($dto);

        return [
            'success' => $success,
            'message' => $success ? 'City created successfully.' : 'Failed to create City.',
        ];
    }

    public function update($id, UpdateCityDTO $dto): array
    {
        return DB::transaction(function () use ($id, $dto) {
            $exists = $this->cityRepo->findById($id);

            if (!$exists) {
                return ['success' => false, 'message' => 'City not found.'];
            }

            $affected = $this->cityRepo->update($id, $dto);

            return [
                'success' => $affected >= 0,
                'message' => 'City updated successfully.',
            ];
        });
    }

    public function checkExist(string $column, mixed $value): bool
    {
        return $this->cityRepo->checkExists($column, $value);
    }
}
