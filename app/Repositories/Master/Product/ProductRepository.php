<?php

namespace App\Repositories\Master\Product;

use App\Database\JoinBuilder;
use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class ProductRepository extends BaseRepository
{

    protected Table $table;
    protected Table $productGroup;

    public function __construct()
    {
        $this->table = table('master', 'product');
        $this->productGroup = table('master', 'product_group');
    }

    private function joinTable(Builder $query): void
    {

        JoinBuilder::leftJoin(
            $query,
            $this->productGroup,
            $this->productGroup->pk(),
            '=',
            $this->table->column("product_group_id")
        );
    }

    public function stream(callable $callback): bool
    {
        $query = parent::all();
        $this->joinTable($query);

        $query->addSelect(
            $this->productGroup->column("product_group_code")
        );

        return $this->chunk(
            $query,
            10000,
            function ($rows) use ($callback) {
                foreach ($rows as $row) {
                    $callback($row);
                }
            },
            'dictionary_id'
        );
    }
}
