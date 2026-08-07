<?php

namespace App\Repositories\Master\ProductEquivalent;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use App\Database\Schema\Table;

class ProductEquivalentRepository extends BaseRepository
{
    protected Table $table;
    public function __construct()
    {
        $this->table = table('master', 'product_equivalent');
    }

    public function all(?array $filters = null): Builder
    {
        return parent::all()
            ->when($filters['product_code'] ?? null, function ($query) use ($filters) {
                return $query->where($this->table->column('product_code'), $filters['product_code']);
            });
    }
}
