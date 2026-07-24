<?php

namespace App\Services\Master;


use App\Repositories\Master\Country\CountryRepository;
use App\DTOs\Master\Country\CreateCountryDTO;
use App\DTOs\Master\Country\UpdateCountryDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class CountryService
{
    protected CountryRepository $countryRepo;

    public function __construct(CountryRepository $countryRepo)
    {
        $this->countryRepo = $countryRepo;
    }

    public function all(): object
    {
        return $this->countryRepo->all()->get();
    }

    public function find(mixed $id): object
    {
        $data = $this->countryRepo->find($id)->first();
        if (!$data) {
            throw new BadRequestException('Country not found.', code: 404);
        }

        return $data;
    }

    public function create(CreateCountryDTO $dto): int
    {
        $id = $this->countryRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create country', code: 400);
        }

        return $id;
    }

    public function update(mixed $id, UpdateCountryDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->countryRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('Country not found', code: 404);
            }
            $this->countryRepo->setAuditSession($dto->toAuditArray());
            $success = $this->countryRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update country');
            }
        });
    }

    public function checkExist(array $conditions): bool
    {
        return $this->countryRepo->exists($dto->columns, $dto->values);
    }
}
