<?php

namespace App\Repositories\Master\Product;

use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    protected string $table = 'precise.product';
    protected string $as = 'p'; 
    protected string $primaryKey = 'p.product_id';
    protected array $columns = [
        'p.product_id',
        'p.product_code',
        'p.product_name',
        'p.product_desc',
        'p.product_category_id',
        'p.product_group_id',
        'p.product_type_id',
        'p.product_status',
        'p.uom_code',
        'p.created_on',
        'p.created_by',
        'p.updated_on',
        'p.updated_by'
    ];

    // Add custom repository methods here
}
