<?php

namespace App\Services\Master\Country;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\Country\CountryRepository;
use App\DTOs\Master\Country\CreateCountryDTO;
use App\DTOs\Master\Country\UpdateCountryDTO;

class CountryService
{
    protected CountryRepository $countryRepo;

    public function __construct(CountryRepository $countryRepo)
    {
        $this->countryRepo = $countryRepo;
    }

    public function getAll()
    {
        return $this->countryRepo->all()->get();
    }

    public function getById(mixed $id): ?object
    {
        return $this->countryRepo->find($id);
    }

    public function create(CreateCountryDTO $dto): array
    {
        $success = $this->countryRepo->create($dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'Country created successfully.' : 'Failed to create country.',
        ];
    }

    public function update($id, UpdateCountryDTO $dto): array
    {
        $success = $this->countryRepo->update($id, $dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'Country updated successfully.' : 'Failed to update country.',
        ];
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->countryRepo->exists($dto->columns, $dto->values);
    }
}
