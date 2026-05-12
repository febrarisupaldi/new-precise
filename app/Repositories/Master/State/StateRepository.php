<?php

namespace App\Repositories\Master\State;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class StateRepository extends BaseRepository
{
    protected string $table = "precise.state";
    protected string $primaryKey = "state_id";
    protected array $columns = [
        "precise.state.state_id",
        "precise.state.state_code",
        "precise.state.state_name",
        "precise.state.created_by",
        "precise.state.created_on",
        "precise.state.updated_by",
        "precise.state.updated_on"
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
