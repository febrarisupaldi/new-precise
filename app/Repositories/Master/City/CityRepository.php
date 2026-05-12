<?php

namespace App\Repositories\Master\City;

use App\DTOs\Master\City\CreateCityDTO;
use App\DTOs\Master\City\UpdateCityDTO;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Resources\Attributes\Collects;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CityRepository extends BaseRepository
{
    protected string $table = 'precise.city';
    protected string $primaryKey = 'city_id';
    protected array $columns = [
        "precise.city.city_id",
        "precise.city.city_name",
        "precise.city.created_by",
        "precise.city.created_on",
        "precise.city.updated_by",
        "precise.city.updated_on"
    ];

    public function all(): Builder
    {
        return parent::all()
            ->addSelect("state.state_name")
            ->join("precise.state", "precise.city.state_id", "=", "precise.state.state_id");
    }

    public function find(mixed $id): Builder
    {
        return parent::find($id)->addSelect("state.state_name")
            ->join("precise.state", "precise.city.state_id", "=", "precise.state.state_id");
    }
}
