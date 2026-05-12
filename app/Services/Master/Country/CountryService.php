<?php

namespace App\Services\Master\Country;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\Country\CountryRepository;
use App\DTOs\Master\Country\CreateCountryDTO;
use App\DTOs\Master\Country\UpdateCountryDTO;
use Illuminate\Support\Facades\DB;

class CountryService
{
    protected CountryRepository $countryRepo;

    public function __construct(CountryRepository $countryRepo)
    {
        $this->countryRepo = $countryRepo;
    }

    public function all(): array
    {
        return [
            "success" => "ok",
            "data" => $this->countryRepo->all()->get()
        ];
    }

    public function find(mixed $id): array
    {
        return [
            "success" => "ok",
            "data" => $this->countryRepo->find($id)->first()
        ];
    }

    public function create(CreateCountryDTO $dto): array
    {
        $success = $this->countryRepo->create($dto->toArray());

        return [
            'success' => $success,
            'message' => $success ? 'Country created successfully.' : 'Failed to create country.',
            'data' => $success ? $dto->toArray() : null
        ];
    }

    public function update($id, UpdateCountryDTO $dto): array
    {
        return DB::transaction(function () use ($id, $dto) {
            $exists = $this->countryRepo->find($id)->first();

            if (!$exists) {
                return ['success' => false, 'message' => 'Country not found.'];
            }
            $this->countryRepo->setAuditSession($dto->toAuditArray());
            $affected = $this->countryRepo->update($id, $dto->withoutAuditArray());

            return [
                'success' => $affected >= 0,
                'message' => 'Country updated successfully.',
                'data' => $affected >= 0 ? $dto->toArray() : null
            ];
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->countryRepo->exists($dto->columns, $dto->values);
    }
}
