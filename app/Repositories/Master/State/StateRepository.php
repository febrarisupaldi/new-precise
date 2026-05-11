<?php

namespace App\Repositories\Master\State;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class StateRepository extends BaseRepository
{
    protected string $table = "precise.state";
    protected string $primaryKey = "state_id";
    protected array $columns = [
        "state_id",
        "state_code",
        "state_name",
        "created_by",
        "created_on",
        "updated_by",
        "updated_on"
    ];

    public function all(): Builder
    {
        return parent::all()
            ->addSelect("country.country_name")
            ->join("precise.country", "precise.state.country_id", "=", "precise.country.country_id");
    }

    public function find(mixed $id): Builder
    {
        return parent::find($id)->addSelect("country.country_name")
            ->join("precise.country", "precise.state.country_id", "=", "precise.country.country_id");
    }
}
