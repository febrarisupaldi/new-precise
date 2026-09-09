<?php

namespace App\Repositories\Master\MachinePressing;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use App\Repositories\Master\MachineStatus\MachineStatusRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MachinePressingRepository extends BaseRepository
{
    protected Table $table;
    protected Table $activity;
    protected Table $moldMaster;
    protected Table $moldDetail;

    public function __construct()
    {
        $this->table = table('master', 'machine_pressing');
        $this->moldMaster = table(
            'master',
            'mold_pressing.master'
        );

        $this->moldDetail = table(
            'master',
            'mold_pressing.detail'
        );
        $this->activity = table('engineering', 'machine_pressing_activity');
    }

    public function all(?array $filters = []): Builder
    {
        $this->table->except(['can_plain', 'can_print', 'can_mug', 'can_bico_lg', 'can_bico_material']);

        $query = parent::all();

        $machineStatus = table('master', 'machine_status');

        JoinBuilder::leftJoin(
            $query,
            $machineStatus,
            $this->table->column('machine_status_code'),
            '=',
            $machineStatus->column('machine_status_code')
        );

        return $query->addSelect(
            $machineStatus->column('status_description'),
            DB::raw("
                case when {$this->table->column('can_plain')} = 1 then 'Ya' else 'Tidak' end as can_plain,  
                case when {$this->table->column('can_print')} = 1 then 'Ya' else 'Tidak' end as can_print,  
                case when {$this->table->column('can_mug')} = 1 then 'Ya' else 'Tidak' end as can_mug,  
                case when {$this->table->column('can_bico_lg')} = 1 then 'Ya' else 'Tidak' end as can_bico_lg, 
                case when {$this->table->column('can_bico_material')} = 1 then 'Ya' else 'Tidak' end as can_bico_material 
            ")
        )->when($filters['code'] ?? null, function ($query) use ($filters) {
            return $query->where($this->table->column('machine_code'), $filters['code']);
        })
            ->when(
                $filters['old_code'] ?? null && $filters['location'] ?? null,
                function ($query) use ($filters) {
                    return $query->where($this->table->column('old_machine_code'), $filters['old_machine_code'])
                        ->where($this->table->column('machine_location'), $filters['machine_location']);
                }
            );
    }

    private function lastActivityQuery(): Builder
    {

        return DB::query()->from($this->activity->from())->select($this->activity->columns())->whereNotNull($this->activity->column('mold_pressing_hd_id'))
            ->addSelect(
                DB::raw("ROW_NUMBER() OVER (
                    PARTITION BY {$this->activity->column('machine_pressing_id')}
                    ORDER BY {$this->activity->column('activity_date')} DESC, {$this->activity->column('trans_date')} DESC
                ) as rn")
            );
    }

    private function baseQueryLastActivity(): Builder
    {
        $query = parent::all();

        $lastActivity = $this->lastActivityQuery();

        return $query->leftJoinSub(
            $lastActivity,
            'mpa',
            function ($join) {
                $join->on(
                    $this->table->column('machine_pressing_id'),
                    '=',
                    $this->activity->column('machine_pressing_id')
                )->where(
                    $this->activity->column('rn'),
                    '=',
                    1
                );
            }
        );
    }

    public function showLastActivity(int $id): Builder
    {
        $query = $this->baseQueryLastActivity();

        JoinBuilder::leftJoin(
            $query,
            $this->moldMaster,
            $this->moldMaster->column('mold_pressing_hd_id'),
            '=',
            $this->activity->column('mold_pressing_hd_id')
        );

        JoinBuilder::leftJoin(
            $query,
            $this->moldDetail,
            $this->moldDetail->column('mold_pressing_hd_id'),
            '=',
            $this->moldMaster->column('mold_pressing_hd_id')
        );

        return $query
            ->addSelect(
                $this->moldMaster->column('mold_number'),
                $this->moldMaster->column('mold_code'),
                $this->moldMaster->column('mold_group'),
                DB::raw("group_concat({$this->moldDetail->column('cavity_number')} ORDER BY {$this->moldDetail->column('cavity_number')} SEPARATOR ',') AS cavities"),

                'mpa.activity_date AS last_activity_date',
                'mpa.trans_date'
            )
            ->where(
                $this->table->pk(),
                $id
            )
            ->groupBy([
                $this->table->column('machine_pressing_id'),
                $this->activity->column('mold_pressing_hd_id'),
                $this->activity->column('activity_date'),
                $this->activity->column('trans_date')
            ])
            ->orderBy($this->table->column('machine_code'))
        ;
    }
    // Add custom repository methods here
}
