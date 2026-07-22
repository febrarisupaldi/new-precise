<?php

namespace App\Repositories\Master\ProductBrand;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

class ProductBrandRepository extends BaseRepository
{
    protected string $table = 'precise.product_brand';
    protected string $as = 'pb';
    protected string $primaryKey = 'pb.product_brand_id';
    protected array $columns = [
        'pb.product_brand_id',
        'pb.product_brand_name',
        'pb.is_active',
        'pb.created_by',
        'pb.created_on',
        'pb.updated_by',
        'pb.updated_on'
    ];

    // Add custom repository methods here
}
