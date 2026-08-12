<?php

namespace App\Repositories\Master\City;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class CityRepository extends BaseRepository
{
    protected Table $table;
    protected Table $state;

    public function __construct()
    {
        $this->table = table('master', 'city');
        $this->state = table('master', 'state');
    }

    private function joinState(Builder $query): void
    {
        JoinBuilder::leftJoin(
            $query,
            $this->state,
            $this->table->column("state_id"),
            '=',
            $this->state->pk()
        );
    }

    public function all(): Builder
    {
        $query = parent::all();

        $this->joinState($query);

        return $query->addSelect(
            $this->state->column('state_name')
        );
    }

    public function find(mixed $id): Builder
    {
        $query = parent::find($id);

        return $query->addSelect(
            $this->state->column('state_name')
        );
    }
}
