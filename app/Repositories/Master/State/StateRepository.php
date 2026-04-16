<?php

namespace App\Repositories\Master\State;

use App\Repositories\BaseRepository;
use App\DTOs\Master\State\CreateStateDTO;
use App\DTOs\Master\State\UpdateStateDTO;
use Illuminate\Support\Collection;

class StateRepository extends BaseRepository
{
    protected $table = 'state';

    public function all(): Collection
    {
        return $this->query()
            ->leftJoin('country', 'state.country_id', '=', 'country.country_id')
            ->select('state.*', 'country.country_name')
            ->orderBy('state.state_name')
            ->get();
    }

    public function findById($id): ?object
    {
        return $this->query()
            ->leftJoin('country', 'state.country_id', '=', 'country.country_id')
            ->select('state.*', 'country.country_name')
            ->where('state.state_id', $id)
            ->first();
    }

    public function create(CreateStateDTO $dto): bool
    {
        return $this->query()->insert([
            'state_code'   => $dto->state_code,
            'state_name'   => $dto->state_name,
            'country_id'   => $dto->country_id,
            'created_by'   => $dto->created_by
        ]);
    }

    public function update($id, UpdateStateDTO $dto): int
    {
        $this->setAuditSession($dto->updated_by, $dto->reason);

        return $this->query()->where('state_id', $id)->update([
            'state_code'   => $dto->state_code,
            'state_name'   => $dto->state_name,
            'country_id'   => $dto->country_id,
            'updated_by'   => $dto->updated_by,
        ]);
    }

    public function checkExists(string $column, mixed $value): bool
    {
        return $this->query()->where($column, $value)->exists();
    }
}
