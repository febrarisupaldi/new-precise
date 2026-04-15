<?php

namespace App\Repositories\Master\Country;

use App\Repositories\BaseRepository;
use App\DTOs\Master\Country\CreateCountryDTO;
use App\DTOs\Master\Country\UpdateCountryDTO;
use Illuminate\Support\Collection;

class CountryRepository extends BaseRepository
{
    protected $table = 'country';

    public function all(): Collection
    {
        return $this->query()->orderBy('country_name')->get();
    }

    public function findById($id): ?object
    {
        return $this->query()->where('country_id', $id)->first();
    }

    public function create(CreateCountryDTO $dto): bool
    {
        return $this->query()->insert([
            'country_code' => $dto->country_code,
            'country_name' => $dto->country_name,
            'created_by'   => $dto->created_by,
        ]);
    }

    public function update($id, UpdateCountryDTO $dto): int
    {
        return $this->query()->where('country_id', $id)->update([
            'country_code' => $dto->country_code,
            'country_name' => $dto->country_name,
            'created_by'   => $dto->created_by,
        ]);
    }

    /**
     * Check if a value exists for a specific column
     */
    public function checkExists(string $column, mixed $value): bool
    {
        return $this->query()->where($column, $value)->exists();
    }
}
