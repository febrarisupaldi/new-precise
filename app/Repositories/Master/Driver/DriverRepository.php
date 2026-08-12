<?php

namespace App\Repositories\Master\Driver;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class DriverRepository extends BaseRepository
{
    protected Table $table;
    protected Table $employee;
    public function __construct()
    {
        $this->table = table("master", "driver");
        $this->employee = table("master", "employee");
    }

    private function joinEmployee(Builder $query): void
    {
        JoinBuilder::leftJoin(
            $query,
            $this->employee,
            $this->table->pk(),
            '=',
            $this->employee->pk()
        );
    }

    public function all(): Builder
    {
        $query = parent::all();

        $this->joinEmployee($query);

        return $query->addSelect(
            $this->employee->column('employee_name')
        );
    }

    public function find(int|string $id): Builder
    {
        $query = parent::find($id);

        return $query->addSelect(
            $this->employee->column('employee_name')
        );
    }
}
