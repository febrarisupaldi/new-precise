<?php

namespace App\Repositories\Master\Packaging;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PackagingRepository extends BaseRepository
{
    protected string $table = 'precise.packaging_hd';
    protected string $as = 'hd';
    protected string $primaryKey = 'hd.packaging_id';
    protected array $columns = [
        'hd.packaging_id',
        'hd.packaging_alias',
        'hd.inner_length',
        'hd.inner_width',
        'hd.inner_height',
        'hd.outer_length',
        'hd.outer_width',
        'hd.outer_height',
        'hd.dimension_uom_code',
        'hd.weight',
        'hd.weight_uom_code',
        'hd.packaging_spec',
        'hd.max_stack',
        'hd.created_on',
        'hd.created_by',
        'hd.updated_on',
        'hd.updated_by'
    ];



    public function all(): Builder
    {
        return parent::all()
            ->leftJoin("precise.product as p", "p.product_id", "hd.packaging_id")
            ->addSelect(
                "p.product_code as packaging_code",
                "p.product_name as packaging_name",
                DB::raw("case hd.is_active when 0 then 'Tidak aktif'
                    when 1 then 'Aktif'
                end as is_active")
            );
    }

    public function show(int $id): Builder
    {
        return parent::find($id)
            ->leftJoin("precise.product as p", "p.product_id", "hd.packaging_id")
            ->addSelect(
                "p.product_code as packaging_code",
                "p.product_name as packaging_name",
                DB::raw("case hd.is_active when 0 then 'Tidak aktif'
                    when 1 then 'Aktif'
                end as is_active")
            );
    }

    public function allWithDetails(): Builder{
        $this->columns = parent::removeColumn(['hd.created_on','hd.updated_on','hd.created_by','hd.updated_by']);
        return parent::all()
            ->leftJoin("precise.packaging_dt as dt", "dt.packaging_id","=", "hd.packaging_id")
            ->leftJoin("precise.product as pph", "hd.packaging_id","=", "pph.product_id")
            ->leftJoin("precise.product as ppd", "dt.packaging_id","=", "ppd.product_id")
            ->addSelect(
                "pph.product_code as packaging_code",
                "pph.product_name as packaging_name",
                "ppd.product_code as product_code",
                "ppd.product_name as product_name",
                "dt.product_id",
                "dt.product_qty",
                "dt.created_on",
                "dt.created_by",
                "dt.updated_on",
                "dt.updated_by"
            );
    }
    // Add custom repository methods here
}
