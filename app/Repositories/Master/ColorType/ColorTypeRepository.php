<?php

namespace App\Repositories\Master\ColorType;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class ColorTypeRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'color_type');
    }
}
