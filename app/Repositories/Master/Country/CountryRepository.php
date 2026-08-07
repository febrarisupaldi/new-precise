<?php

namespace App\Repositories\Master\Country;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class CountryRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'country');
    }
}
