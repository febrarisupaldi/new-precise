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

    public function all(): object
    {
        return $this->cityRepo->all()->get();
    }

    public function find(int $id): ?object
    {
        return $this->cityRepo->find($id)->first();
    }

    public function create(CreateCityDTO $dto): array
    {
        $success = $this->cityRepo->create($dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'City created successfully.' : 'Failed to create City.',
        ];
    }

    public function update(int $id, UpdateCityDTO $dto): array
    {
        $success = $this->cityRepo->update($id, $dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'City updated successfully.' : 'Failed to update city.',
        ];
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
