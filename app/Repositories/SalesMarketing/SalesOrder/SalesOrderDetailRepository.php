<?php

namespace App\Repositories\SalesMarketing\SalesOrder;

use App\Repositories\BaseRepository;

class SalesOrderDetailRepository extends BaseRepository
{
    protected string $table = 'sales_order_details';

    protected string $primaryKey = '';

    protected array $columns = [];

    /**
     * Bulk insert
     */
    public function insertBatch(
        array $rows
    ): bool {

        return $this->query()
            ->insert($rows);
    }
}
