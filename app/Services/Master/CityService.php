<?php

namespace App\Services\Master;

use App\DTOs\ExistsDTO;
use App\Repositories\Master\City\CityRepository;
use App\DTOs\Master\City\CreateCityDTO;
use App\DTOs\Master\City\UpdateCityDTO;
use App\Exceptions\BadRequestException;
use Exception;
use Illuminate\Support\Facades\DB;

class CityService
{
    protected CityRepository $cityRepo;

    public function __construct(CityRepository $cityRepo)
    {
        $this->cityRepo = $cityRepo;
    }

    public function all(): object
    {
        return $this->cityRepo->all()->get();
    }

    public function find(int $id): object
    {
        $data = $this->cityRepo->find($id)->first();
        if (!$data) {
            throw new BadRequestException('City not found.', code: 404);
        }

        return $data;
    }

    public function create(CreateCityDTO $dto): int
    {
        $id = $this->cityRepo->insert($dto->toArray());

        if (!$id) {
            throw new Exception('Failed to create city');
        }

        return $id;
    }

    public function update(int $id, UpdateCityDTO $dto): void
    {
        DB::transaction(function () use ($id, $dto) {
            $exists = $this->cityRepo->find($id)->first();

            if (!$exists) {
                throw new BadRequestException('City not found', code: 404);
            }
            $this->cityRepo->setAuditSession($dto->toAuditArray());
            $success = $this->cityRepo->update($id, $dto->withoutAuditArray());

            if ($success === false) {
                throw new Exception('Failed to update city');
            }
        });
    }

    public function checkExist(ExistsDTO $dto): bool
    {
        return $this->cityRepo->exists($dto->columns, $dto->values);
    }
}
