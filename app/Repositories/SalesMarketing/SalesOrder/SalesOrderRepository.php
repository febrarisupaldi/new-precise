<?php

namespace App\Repositories\SalesMarketing\SalesOrder;

use App\Database\Schema\Table;
use App\Repositories\BaseRepository;
use App\Repositories\Master\City\CityRepository;
use App\Repositories\Master\Product\ProductRepository;
use App\Repositories\Master\Warehouse\WarehouseRepository;
use App\Repositories\SalesMarketing\SalesOrder\SalesOrderDetailRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SalesOrderRepository extends BaseRepository
{
    protected Table $salesOrder;
    protected array $columns = [
        'sales_order_hd_id',
        'sales_order_number',
        'sales_order_date',
        'cancel_date',
        'est_delivery_date',
        'customer_id',
        'warehouse_id',
        'purchase_order_number',
        'sales_order_description',
        'currency_code',
        'toc',
        'ppn_type',
        'discount_type',
        'sales_order_status',
        'sales_person',
        'is_released',
        'unreleased_reason',
        'memo_number',
        'created_on',
        'created_by',
        'updated_on',
        'updated_by'
    ];

    public function __construct()
    {
        $this->salesOrder = table('sales', 'sales-order.master');
    }
    public function allWithFilter(array $filter): Builder
    {
        return parent::all()
            ->when(
                isset($filter['start']) && isset($filter['end']) && $filter['number'] == null,
                function ($query) use ($filter) {
                    return $query->addSelect(
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
                        ->leftJoin(
                            $this->salesOrderDetailRepository->getTable() . " as " . $this->salesOrderDetailRepository->getAlias(),
                            $this->salesOrderDetailRepository->getPrimaryKey(),
                            "=",
                            $this->primaryKey
                        )
                        ->leftJoin(
                            $this->productRepository->getTable() . " as " . $this->productRepository->getAlias(),
                            $this->productRepository->getPrimaryKey(),
                            "=",
                            "dt.product_id"
                        );
                }
            )
            ->when($filter['number'] != null, function ($query) use ($filter) {
                $this->setPrimaryKey("hd.sales_order_number");
                return $this->show($filter['number']);
            });;
    }

    public function show(string|int $id): Builder
    {
        $this->columns = $this->removeColumn([
            'sales_order_status'
        ]);
        return parent::find($id)->addSelect(
            "cust.customer_code",
            "cust.customer_name",
            DB::raw("0 AS so_type,0 AS toc,0 AS delivery_type,CASE sales_order_status 
                    WHEN 'A' THEN 'Approved'
                    WHEN 'X' THEN 'Close' 
                    WHEN 'C' THEN 'Cancel' 
                    WHEN 'O' THEN 'Open' 
                    ELSE 'Outstanding'
                END AS sales_order_status,
                0 AS curr_rate, 0 as tax_rate, NULL as stockable"),
            "ca.customer_address_id",
            "ca.address as ship_address",
            "rt.retail_type_id AS sales_organization",
            "rt.retail_type_code AS sales_organization_code",
            "rt.retail_type_description AS sales_organization_name",
            "cc.cost_center_id AS revenue_center",
            "cc.cost_center_code AS revenue_center_code",
            "cc.cost_center_name AS revenue_center_name",
            "emp.employee_name",
            "w.warehouse_code",
            "w.warehouse_name"
        )->leftJoin("precise.customer as cust", "cust.customer_id", "=", "hd.customer_id")
            ->leftJoin("precise.customer_address as ca", function ($join) {
                $join->on("cust.customer_id", "=", "ca.customer_id");
                $join->on("ca.address_type_id", "=", DB::raw(1));
                $join->on("ca.is_default", "=", DB::raw(1));
            })
            ->leftJoin(
                $this->cityRepository->getTable() . " as " . $this->cityRepository->getAlias(),
                "ca.city_id",
                "=",
                $this->cityRepository->getPrimaryKey()
            )
            ->leftJoin(
                $this->warehouseRepository->getTable() . " as " . $this->warehouseRepository->getAlias(),
                "hd.warehouse_id",
                "=",
                $this->warehouseRepository->getPrimaryKey()
            )
            ->leftJoin("precise.retail_type as rt", "cust.retail_type_id", "=", "rt.retail_type_id")
            ->leftJoin("precise.revenue_center as rc", "rt.retail_type_id", "=", "rc.retail_type_id")
            ->leftJoin("precise.cost_center as cc", "rc.cost_center_id", "=", "cc.cost_center_id")
            ->leftJoin("precise.employee as emp", "hd.sales_person", "=", "emp.employee_nik");
    }
    // Add custom repository methods here
}
