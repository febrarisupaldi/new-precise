<?php

namespace App\Repositories\Master\City;

use App\DTOs\Master\City\CreateCityDTO;
use App\DTOs\Master\City\UpdateCityDTO;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CityRepository extends BaseRepository
{
    protected $table = 'precise.city'; // Change to actual table name

    // Add custom repository methods here

    public function all(): Collection
    {
        return $this->query()
            ->select("city_id", "city_name", "state_name", "precise.city.created_by", "precise.city.created_on", "precise.city.updated_by", "precise.city.updated_on")
            ->join("precise.state", "precise.city.state_id", "=", "precise.state.state_id")
            ->get();
    }

    public function findById($id): ?object
    {
        return $this->query()
            ->select("city_id", "city_name", "state_id", "state_name", "created_by", "created_on")
            ->join("precise.state", "precise.city.state_id", "=", "precise.state.state_id")
            ->where("city_id", $id)
            ->first();
    }

    public function create(CreateCityDTO $dto): bool
    {
        return $this->query()->insert([
            'city_code' => $dto->city_code,
            'city_name' => $dto->city_name,
            'state_id' => $dto->state_id,
            'created_by' => $dto->created_by,
        ]);
    }

    public function update(int $id, UpdateCityDTO $dto): int
    {
        return DB::transaction(function () use ($id, $dto) {
            $this->findById($id);

            $this->setAuditSession($dto->updated_by, $dto->reason);
            return $this->query()
                ->where('city_id', $id)
                ->update([
                    'city_name' => $dto->city_name,
                    'state_id' => $dto->state_id,
                    'updated_by' => $dto->updated_by,
                ]);
        });
    }

    public function checkExists(string $column, mixed $value): bool
    {
        return $this->query()->where($column, $value)->exists();
    }
}
