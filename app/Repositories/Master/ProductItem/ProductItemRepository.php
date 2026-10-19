<?php

namespace App\Repositories\Master\ProductItem;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class ProductItemRepository extends BaseRepository
{
    protected Table $table;
    protected Table $productSeries;

    public function __construct()
    {
        $this->table = table("master", "product_item");
        $this->productSeries = table("master", "product_series");
    }

    public function all(): Builder
    {
        $query = parent::all();
        JoinBuilder::leftJoin(
            $query,
            $this->productSeries,
            $this->productSeries->pk(),
            '=',
            $this->table->column("series_id")
        );

        return $query->addSelect(
            $this->productSeries->column("series_name")
        );
    }
}
