<?php

namespace App\Repositories\SalesMarketing\SalesOrder;

use App\Repositories\BaseRepository;
use App\Repositories\Master\Product\ProductRepository;
use App\Repositories\Master\ProductEquivalent\ProductEquivalentRepository;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class SalesOrderDetailRepository extends BaseRepository
{
    private ProductRepository $productRepository;
    private ProductEquivalentRepository $productEquivalentRepository;
    
    protected string $table = 'precise.sales_order_dt';
    protected string $as = 'dt';
    protected string $primaryKey = 'dt.sales_order_dt_id';
    protected array $columns = [
        'dt.sales_order_dt_id',
        'dt.sales_order_hd_id',
        'dt.sales_order_number',
        'dt.sales_order_seq',
        'dt.sales_order_status',
        'dt.product_id',
        'dt.customer_article_dt_id',
        'dt.sales_order_qty',
        'dt.uom_code',
        'dt.cost_center_id',
        'dt.price',
        'dt.qty_price',
        'dt.percent_disc1',
        'dt.percent_disc2',
        'dt.percent_disc3',
        'dt.disc1',
        'dt.disc2',
        'dt.disc3',
        'dt.before_disc',
        'dt.after_disc',
        'dt.bruto',
        'dt.netto',
        'dt.ppn',
        'dt.net',
        'dt.created_on',
        'dt.created_by',
        'dt.updated_on',
        'dt.updated_by'
    ];

    public function __construct(ProductRepository $productRepository, ProductEquivalentRepository $productEquivalentRepository)
    {
        $this->productRepository = $productRepository;
        $this->productEquivalentRepository = $productEquivalentRepository;
    }

    public function findByMasterID(string|int $id): Builder{
        $query = DB::table($this->table, $this->as)
            ->addSelect(
                'p.product_code',
                'p.product_name',
                DB::raw("NULL as due_date,(CASE
                    WHEN eq.qty_conversion IS NULL 
                        THEN CONCAT(TRIM(dt.sales_order_qty)+0, ' ', dt.uom_code)
                    ELSE
                        (CASE 
                            WHEN dt.uom_code = 'DUS' 
                                THEN CONCAT((TRIM(dt.sales_order_qty / eq.qty_std * eq.qty_conversion)+0), ' LS')
                            WHEN dt.uom_code = 'PCS' 
                                THEN CONCAT((TRIM(dt.sales_order_qty)+0), ' ', dt.uom_code)
                            ELSE
                                CONCAT(TRIM(dt.sales_order_qty)+0 , ' ', dt.uom_code)
                            END)
                    END) AS concatedConversionQty"),

            )
        ->leftJoin($this->productRepository->getTable(). ' as ' .$this->productRepository->getAlias(), $this->productRepository->getPrimaryKey(), '=', 'dt.product_id')
        ->leftJoin($this->productEquivalentRepository->getTable(). ' as ' .$this->productEquivalentRepository->getAlias(), function($join) {
            $join->on('p.product_code', '=', 'eq.product_code');
            $join->on("eq.uom_code","=", DB::raw("CASE
                            WHEN dt.uom_code = 'PCS' THEN 'PCS'
                            ELSE 'LS'
                        END"));
        });

        if(is_string($id)){
            $query->where('dt.sales_order_number', $id);
        }else{
            $query->where('dt.sales_order_hd_id', $id);
        }

        return $query;
    }
}
