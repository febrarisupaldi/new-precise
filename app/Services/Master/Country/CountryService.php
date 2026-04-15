<?php

namespace App\Services\Master\Country;

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
        return $this->countryRepo->all();
    }

    public function getById($id)
    {
        return $this->countryRepo->findById($id);
    }

    public function create(CreateCountryDTO $dto): array
    {
        $success = $this->countryRepo->create($dto);

        return [
            'success' => $success,
            'message' => $success ? 'Country created successfully.' : 'Failed to create country.',
        ];
    }

    public function update($id, UpdateCountryDTO $dto): array
    {
        $exists = $this->countryRepo->findById($id);

        if (!$exists) {
            return ['success' => false, 'message' => 'Country not found.'];
        }

        $this->countryRepo->update($id, $dto);

        return ['success' => true, 'message' => 'Country updated successfully.'];
    }

    public function checkExist(string $column, mixed $value): bool
    {
        return $this->countryRepo->checkExists($column, $value);
    }
}
