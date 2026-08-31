<?php

namespace App\Repositories\Engineering\MachinePressingActivity;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use InvalidArgumentException;

class MachinePressingActivityRepository extends BaseRepository
{
    protected Table $table;
    protected Table $machinePressing;
    protected Table $moldPressing;
    protected Table $employee;

    public function __construct()
    {
        $this->table = table("engineering", "machine_pressing_activity");
        $this->machinePressing = table("master", "machine_pressing");
        $this->moldPressing = table("master", "mold_pressing.master");
        $this->employee = table("human-resource", "employee");
    }

    public function joinTable(Builder $query): void
    {
        JoinBuilder::leftJoin(
            $query,
            $this->machinePressing,
            $this->machinePressing->pk(),
            '=',
            $this->table->column('machine_pressing_id')
        );

        JoinBuilder::leftJoin(
            $query,
            $this->moldPressing,
            $this->moldPressing->pk(),
            '=',
            $this->table->column('mold_pressing_hd_id')
        );

        JoinBuilder::leftJoin(
            $query,
            $this->employee,
            $this->employee->pk(),
            '=',
            $this->table->column('setter_mold_nik')
        );
    }

    public function all(array $filters = []): Builder
    {
        $query = parent::all();

        $this->joinTable($query);

        if (
            isset($filters['trans_date']) &&
            isset($filters['shift']) &&
            isset($filters['location'])
        ) {
            $query->where([
                [$this->table->column('trans_date'), '=', $filters['trans_date']],
                [$this->table->column('shift'), '=', $filters['shift']],
                [$this->table->column('machine_location'), '=', $filters['location']],
            ]);
        } else {
            throw new InvalidArgumentException("Invalid Arguments");
        }

        return $query->addSelect(
            $this->machinePressing->only(["machine_code", "old_machine_code", "line_code", "line_number", "machine_location"]),
            $this->moldPressing->only(["mold_number", "mold_code"]),
            $this->employee->column("NAMA as setter_mold_name")
        )
            ->when($filters['machine_pressing'] ?? null, function ($query) use ($filters) {
                $query->where($this->machinePressing->column("machine_pressing"), $filters['machine_pressing']);
            })
            ->orderByDesc($this->table->pk());
    }
}
