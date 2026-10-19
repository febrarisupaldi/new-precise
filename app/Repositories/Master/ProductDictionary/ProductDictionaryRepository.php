<?php

namespace App\Repositories\Master\ProductDictionary;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class ProductDictionaryRepository extends BaseRepository
{
    protected Table $table;
    protected Table $product;
    protected Table $productItem;
    protected Table $productDesign;
    protected Table $productBrand;
    protected Table $productVariant;
    protected Table $colorType;

    public function __construct()
    {
        $this->table = table("master", "product_dictionary");
        $this->product = table("master", "product");
        $this->productBrand = table("master", "product_brand");
        $this->productItem = table("master", "product_item");
        $this->productDesign = table("master", "product_design")->withAlias("prod_des");
        $this->productVariant = table("master", "product_variant");
        $this->colorType = table("master", "color_type");
    }

    private function JoinTable(Builder $query): void
    {
        JoinBuilder::leftJoin(
            $query,
            $this->product,
            $this->table->column('product_id'),
            '=',
            $this->product->pk()
        );

        JoinBuilder::leftJoin(
            $query,
            $this->productBrand,
            $this->productBrand->pk(),
            '=',
            $this->table->column('brand_id')
        );

        JoinBuilder::leftJoin(
            $query,
            $this->productDesign,
            $this->productDesign->pk(),
            '=',
            $this->table->column('design_id')
        );

        JoinBuilder::leftJoin(
            $query,
            $this->productItem,
            $this->productItem->pk(),
            '=',
            $this->table->column('item_id')
        );

        JoinBuilder::leftJoin(
            $query,
            $this->productVariant,
            $this->productVariant->pk(),
            '=',
            $this->table->column('variant_id')
        );

        JoinBuilder::leftJoin(
            $query,
            $this->colorType,
            $this->colorType->pk(),
            '=',
            $this->table->column('color_id')
        );
    }

    private function baseQuery(Builder $query): Builder
    {

        $this->JoinTable($query);

        $query->addSelect(
            $this->product->column('product_code'),
            $this->product->column('product_name'),
            $this->productItem->column('item_code'),
            $this->productItem->column('item_name'),
            $this->productVariant->column('product_variant_code'),
            $this->productVariant->column('product_variant_name'),
            $this->productDesign->column('design_code'),
            $this->productDesign->column('design_name'),
            $this->productBrand->column('product_brand_name'),
            DB::raw(
                "CONCAT({$this->colorType->column('color_type_code')} - {$this->colorType->column('color_type_name')}) AS color_type"
            ),
            DB::raw(
                "CASE 
                        WHEN {$this->table->column('is_active_sell')} = '1' THEN 'Aktif'
                        WHEN {$this->table->column('is_active_sell')} = '0' THEN 'Tidak aktif'
                    ELSE NULL
                    END as 'active_sell'
            "
            ),
            DB::raw(
                "CASE 
                        WHEN {$this->table->column('is_active_production')} = '1' THEN 'Aktif'
                        WHEN {$this->table->column('is_active_production')} = '0' THEN 'Tidak aktif'
                    ELSE NULL
                    END as 'active_production'
            "
            )
        );

        return $query;
    }

    public function all(): Builder
    {

        $all = parent::all();
        $query = $this->baseQuery($all);
        return $query;
    }

    public function stream(callable $callback): bool
    {
        $this->table->only([
            'dictionary_id',
            'packing_qty',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ]);

        $query = $this->all();

        return $this->chunk(
            $query,
            30000,
            function ($rows) use ($callback) {
                foreach ($rows as $row) {
                    $callback($row);
                }
            },
            'dictionary_id',
        );
    }
}
