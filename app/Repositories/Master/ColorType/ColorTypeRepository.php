<?php

namespace App\Repositories\Master\ColorType;

use App\Repositories\BaseRepository;

class ColorTypeRepository extends BaseRepository
{
    protected string $table = 'precise.color_type';
    protected string $as = 'ct';
    protected string $primaryKey = 'ct.color_type_id';
    protected array $columns = [
        'ct.color_type_id',
        'ct.color_type_code',
        'ct.color_type_name',
        'ct.created_by',
        'ct.created_on',
        'ct.updated_by',
        'ct.updated_on'
    ];

    // Add custom repository methods here
}
