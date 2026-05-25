<?php

namespace App\Repositories\Master\Packaging;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PackagingRepository extends BaseRepository
{
    protected string $table = 'precise.packaging_hd';
    protected string $as = 'ph';
    protected string $primaryKey = 'ph.packaging_id';
    protected array $columns = [
        'ph.packaging_id',
        'ph.packaging_alias',
        'ph.inner_length',
        'ph.inner_width',
        'ph.inner_height',
        'ph.outer_length',
        'ph.outer_width',
        'ph.outer_height',
        'ph.dimension_uom_code',
        'ph.weight',
        'ph.weight_uom_code',
        'ph.packaging_spec',
        'ph.max_stack',
        'ph.created_on',
        'ph.created_by',
        'ph.updated_on',
        'ph.updated_by'
    ];


    
    public function all(): Builder
    {
        return parent::all()
            ->leftJoin("precise.product as p", "p.product_id", "ph.packaging_id")
            ->addSelect(
                "p.product_code as packaging_code",
                "p.product_name as packaging_name",
                DB::raw("case ph.is_active when 0 then 'Tidak aktif'
                    when 1 then 'Aktif'
                end as is_active")
            );
    }

    public function show(int $id): Builder
    {
        return parent::find($id)
            ->leftJoin("precise.product as p", "p.product_id", "ph.packaging_id")
            ->addSelect(
                "p.product_code as packaging_code",
                "p.product_name as packaging_name",
                DB::raw("case ph.is_active when 0 then 'Tidak aktif'
                    when 1 then 'Aktif'
                end as is_active")
            );
    }
    // Add custom repository methods here
}
