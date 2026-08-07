<?php

namespace App\Repositories\Master\CompanyType;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;

class CompanyTypeRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table('master', 'company_type');
    }
}
