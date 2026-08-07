<?php

return [
    'sales-order' => [
        'master' => [
            'table' => 'precise.sales_order_hd',
            'primary_key' => 'sales_order_hd_id',
            'default_alias' => 'sohd',
            'columns' => [
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
            ],
            'exists' => []
        ],
        'detail' => [
            'table' => 'precise.sales_order_dt',
            'primary_key' => 'sales_order_dt_id',
            'default_alias' => 'sodt',
            'columns' => [
                'sales_order_dt_id',
                'sales_order_hd_id',
                'sales_order_number',
                'sales_order_seq',
                'sales_order_status',
                'product_id',
                'customer_article_dt_id',
                'sales_order_qty',
                'uom_code',
                'cost_center_id',
                'price',
                'qty_price',
                'percent_disc1',
                'percent_disc2',
                'percent_disc3',
                'disc1',
                'disc2',
                'disc3',
                'before_disc',
                'after_disc',
                'bruto',
                'netto',
                'ppn',
                'net',
                'created_on',
                'created_by',
                'updated_on',
                'updated_by'
            ],
            'exists' => []
        ]
    ]
];
