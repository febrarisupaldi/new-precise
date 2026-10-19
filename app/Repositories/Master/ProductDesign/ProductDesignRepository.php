<?php

namespace App\Repositories\Master\ProductDesign;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ProductDesignRepository extends BaseRepository
{
    protected Table $table;
    protected Table $productAppearance;
    protected Table $productLicenseType;
    protected Table $colorType;

    public function __construct()
    {
        $this->table = table("master", "product_design");
        $this->productAppearance = table("master", "product_appearance");
        $this->productLicenseType = table("master", "product_license_type");
        $this->colorType = table("master", "color_type");
    }

    private function joinTable(Builder $query): void
    {
        JoinBuilder::leftJoin(
            $query,
            $this->productAppearance,
            $this->table->column("appearance_id"),
            '=',
            $this->productAppearance->pk()
        );

        JoinBuilder::leftJoin(
            $query,
            $this->productLicenseType,
            $this->table->column("license_type_id"),
            '=',
            $this->productLicenseType->pk()
        );

        JoinBuilder::leftJoin(
            $query,
            $this->colorType,
            $this->table->column("color_type_id"),
            '=',
            $this->colorType->pk()
        );
    }

    public function all(): Builder
    {
        $query = parent::all();
        $this->joinTable($query);

        $this->table->except(
            [
                'is_active_sell',
                'is_active_production',
                'is_active'
            ]
        );

        $query->addSelect(
            $this->productAppearance->column('appearance_name'),
            $this->productLicenseType->column('license_type_name'),
            DB::raw(
                "concat({$this->colorType->column('color_type_code')}, ' - ', {$this->colorType->column('color_type_name')}) as 'color_type'"
            ),
            DB::raw(
                " case {$this->table->column('is_active_sell')}
                        when 0 then 'Tidak aktif'
                        when 1 then 'Aktif' 
                    end as 'is_active_sell'"
            ),
            DB::raw(
                " case {$this->table->column('is_active_production')}
                        when 0 then 'Tidak aktif'
                        when 1 then 'Aktif' 
                    end as 'is_active_production'"
            ),
            DB::raw(
                " case {$this->table->column('is_active')}
                        when 0 then 'Tidak aktif'
                        when 1 then 'Aktif' 
                    end as 'is_active'"
            )
        );

        return $query;
    }
}
