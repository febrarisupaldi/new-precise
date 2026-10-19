<?php

namespace App\Repositories\SalesMarketing\SalesOrder;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SalesOrderDetailRepository extends BaseRepository
{
    protected Table $table;

    public function __construct()
    {
        $this->table = table("sales", "sales-order.detail");
    }
}
