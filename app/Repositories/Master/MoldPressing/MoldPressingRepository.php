<?php

namespace App\Repositories\Master\MoldPressing;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class MoldPressingRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'mold_pressing.master');
    }

    public function all(?array $filters = []): Builder
    {
        $query = parent::all();

        $moldStatus = table('master', 'mold_status');
        $moldPressingDetail = table('master', 'mold_pressing.detail');

        JoinBuilder::leftJoin(
            $query,
            $moldStatus,
            $this->table->column('mold_status_code'),
            '=',
            $moldStatus->column('status_code')
        );


        return $query->addSelect(
            $moldStatus->column('status_description')
        )->when($filters['number'] ?? null, function ($query) use ($filters) {
            return $query->where($this->table->column('mold_number'), $filters['number']);
        })
            ->when($filters['with'] ?? null, function ($query) use ($filters, $moldPressingDetail) {
                JoinBuilder::leftJoin(
                    $query,
                    $moldPressingDetail,
                    $this->table->column('mold_pressing_hd_id'),
                    '=',
                    $moldPressingDetail->column('mold_pressing_hd_id')
                );
                return $query->addSelect(
                    $moldPressingDetail->column('mold_pressing_dt_id'),
                    $moldPressingDetail->column('cavity_number'),
                    $moldPressingDetail->column('product_weight'),
                    $moldPressingDetail->column('product_weight_uom'),
                    $moldPressingDetail->column('is_active')
                );
            })
            ->when($filters['code'] ?? null, function ($query) use ($filters, $moldPressingDetail) {
                JoinBuilder::leftJoin(
                    $query,
                    $moldPressingDetail,
                    $this->table->column('mold_pressing_hd_id'),
                    '=',
                    $moldPressingDetail->column('mold_pressing_hd_id')
                );
                return $query->addSelect(
                    $moldPressingDetail->column("product_weight"),
                    $moldPressingDetail->column("product_weight_uom"),
                    DB::raw("group_concat({$moldPressingDetail->column('cavity_number')} ORDER BY {$moldPressingDetail->column('cavity_number')} SEPARATOR ',') AS cavities")
                )
                    ->where($this->table->column('mold_code'), 'like', '%' . $filters['code'] . '%')
                    ->groupBy(
                        $this->table->column('mold_pressing_hd_id'),
                        $this->table->column('mold_number'),
                        $moldPressingDetail->column('product_weight'),
                        $moldPressingDetail->column('product_weight_uom')
                    );
            });;
    }

    public function find(int|string $id): Builder
    {
        if (is_numeric($id)) {
            $query = parent::find($id);
        } else {
            $query = parent::findByColumn([$this->table->column("mold_number") => $id]);
        }
        return $query;
    }
    // Add custom repository methods here
}
