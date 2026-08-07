<?php

namespace App\Repositories\Master\Packaging;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PackagingRepository extends BaseRepository
{

    protected Table $table;

    public function __construct()
    {
        $this->table = table("master", "packaging.master");
    }

    public function all(?array $filters = null): Builder
    {
        $query = parent::all();

        $product = table("master", "product")->withAlias("prod");

        JoinBuilder::leftJoin(
            $query,
            $product,
            $this->table->column("packaging_id"),
            '=',
            $product->column("product_id")
        );

        return $query
            ->addSelect(
                $product->column("product_code as packaging_code"),
                $product->column("product_name as packaging_name"),
                DB::raw("case {$this->table->column('is_active')} when 0 then 'Tidak aktif'
                    when 1 then 'Aktif'
                end as is_active")
            )
            ->when($filters['status'] ?? null, function ($query) use ($filters) {
                return $query->where($this->table->column('is_active'), $filters['status']);
            })
            ->when($filters['include'] ?? null && $filters['include'] === 'details', function ($query) use ($product) {
                $this->table->except([
                    'created_by',
                    'updated_by',
                    'created_on',
                    'updated_on'
                ]);
                $packagingDetail = table("master", "packaging.detail");
                $product2 = table("master", "product")
                    ->withAlias("prod2");

                JoinBuilder::leftJoin(
                    $query,
                    $packagingDetail,
                    $this->table->column("packaging_id"),
                    '=',
                    $packagingDetail->column("packaging_id")
                );

                JoinBuilder::leftJoin(
                    $query,
                    $product2,
                    $packagingDetail->column("product_id"),
                    '=',
                    $product2->column("product_id")
                );
                return $query
                    ->addSelect(
                        $product2->column("product_code"),
                        $product2->column("product_name"),
                        $packagingDetail->column('product_id'),
                        $packagingDetail->column('product_qty'),
                        $packagingDetail->column('created_on'),
                        $packagingDetail->column('created_by'),
                        $packagingDetail->column('updated_on'),
                        $packagingDetail->column('updated_by')
                    );
            });
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

    public function allWithDetails(): Builder
    {
        return parent::all()
            ->leftJoin("precise.packaging_dt as dt", "dt.packaging_id", "=", "hd.packaging_id")
            ->leftJoin("precise.product as pph", "hd.packaging_id", "=", "pph.product_id")
            ->leftJoin("precise.product as ppd", "dt.packaging_id", "=", "ppd.product_id")
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
