<?php

namespace App\Repositories\Master\ProductDesign;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

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

    public function all(): Builder
    {
        $query = parent::all();

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

        return $query;
    }
}
