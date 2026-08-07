<?php

namespace App\Repositories\Master\State;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class StateRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'state');
    }

    public function all(): Builder
    {
        $country = table("master", "country");
        $query = parent::all();

        JoinBuilder::leftJoin(
            $query,
            $country,
            $this->table->column("country_id"),
            "=",
            $country->column("country_id")
        );

        return $query->addSelect(
            $country->column("country_name")
        );
    }

    public function find(mixed $id): Builder
    {
        $country = table("master", "country");
        $query = parent::find($id);

        JoinBuilder::leftJoin(
            $query,
            $country,
            $this->table->column("country_id"),
            "=",
            $country->column("country_id")
        );

        return $query->addSelect(
            $country->column("country_name")
        );
    }
}
