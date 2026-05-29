<?php

namespace App\Repositories\Master\ProductEquivalent;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class ProductEquivalentRepository extends BaseRepository
{
    protected string $table = 'precise.product_equivalent'; 
    protected string $as = 'eq';
    protected string $primaryKey = 'eq.equivalent_id';
    protected array $columns = [
        'eq.equivalent_id',
        'eq.product_code',
        'eq.uom_code',
        'eq.qty_std',
        'eq.qty_conversion',
        'eq.updated_by',
        'eq.updated_on',
    ];

    // Add custom repository methods here

    public function findByProductCode(string $productCode): Builder
    {
        return $this->all()
            ->where('eq.product_code', $productCode);
    }
}
