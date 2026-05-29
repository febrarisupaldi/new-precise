<?php

namespace App\Repositories\SalesMarketing\SalesOrder;

use App\Repositories\BaseRepository;
use App\Repositories\Master\Product\ProductRepository;
use App\Repositories\SalesMarketing\SalesOrder\SalesOrderDetailRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SalesOrderRepository extends BaseRepository
{
    protected SalesOrderDetailRepository $salesOrderDetailRepository;
    protected ProductRepository $productRepository;
    protected string $table = 'precise.sales_order_hd'; 
    protected string $as = 'hd';
    protected string $primaryKey = 'hd.sales_order_hd_id';
    protected array $columns = [
        'hd.sales_order_hd_id',
        'hd.sales_order_number',
        'hd.sales_order_date',
        'hd.cancel_date',
        'hd.est_delivery_date',
        'hd.customer_id',
        'hd.warehouse_id',
        'hd.purchase_order_number',
        'hd.sales_order_description',
        'hd.currency_code',
        'hd.toc',
        'hd.ppn_type',
        'hd.discount_type',
        'hd.sales_order_status',
        'hd.sales_person',
        'hd.is_released',
        'hd.unreleased_reason',
        'hd.memo_number',
        'hd.created_on',
        'hd.created_by',
        'hd.updated_on',
        'hd.updated_by'
    ];

    public function __construct(SalesOrderDetailRepository $salesOrderDetailRepository, ProductRepository $productRepository)
    {
        $this->salesOrderDetailRepository = $salesOrderDetailRepository;
        $this->productRepository = $productRepository;
    }
    public function allWithFilter(array $filter): Builder{
        return parent::all()
            ->when(
                isset($filter['start']) && isset($filter['end']), 
                function($q) use ($filter){
                    return $q->addSelect(
                        "dt.sales_order_seq",
                        "dt.uom_code",
                        "p.product_code",
                        "p.product_name",
                        "dt.sales_order_qty",
                        "dt.price",
                        'dt.qty_price',
                        'dt.percent_disc1',
                        'dt.percent_disc2',
                        'dt.percent_disc3',
                        'dt.disc1',
                        'dt.disc2',
                        'dt.disc3',
                        DB::raw("disc1+disc2+disc3 as 'total_disc'"),
                        "dt.after_disc",
                        "dt.bruto",
                        "dt.netto",
                        "dt.ppn",
                        "dt.net"
                    )
                    ->whereBetween("hd.sales_order_date", [$filter['start'], $filter['end']])
                    ->leftJoin($this->salesOrderDetailRepository->getTable(). " as " .$this->salesOrderDetailRepository->getAlias(),
                        $this->salesOrderDetailRepository->getPrimaryKey(), "=", $this->primaryKey
                    )
                    ->leftJoin($this->productRepository->getTable(). " as " .$this->productRepository->getAlias(),
                        $this->productRepository->getPrimaryKey(), "=", "dt.product_id"
                    );
                })
        ;
    }

    // Add custom repository methods here
}
