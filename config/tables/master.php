<?php

return [
    'address_type' => [
        'table' => 'precise.address_type',
        'primary_key' => 'address_type_id',
        'default_alias' => 'at',
        'columns' => [
            'address_type_id',
            'address_type_name',
            'address_type_description',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['address_type_name']
        ]
    ],
    'city' => [
        'table' => 'precise.city',
        'primary_key' => 'city_id',
        'default_alias' => 'c',
        'columns' => [
            'city_id',
            'city_code',
            'city_name',
            'state_id',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['city_code'],
            ['city_name']
        ]
    ],
    'color_type' => [
        'table' => 'precise.color_type',
        'primary_key' => 'color_type_id',
        'default_alias' => 'ct',
        'columns' => [
            'color_type_id',
            'color_type_code',
            'color_type_name',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['color_type_name']
        ]
    ],
    'company_type' => [
        'table' => 'precise.company_type',
        'primary_key' => 'company_type_id',
        'default_alias' => 'ct',
        'columns' => [
            'company_type_id',
            'company_type_code',
            'company_type_description',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['company_type_name']
        ]
    ],

    'cooling_method' => [
        'table' => 'precise.cooling_method',
        'primary_key' => 'cooling_method_id',
        'default_alias' => 'cm',
        'columns' => [
            'cooling_method_id',
            'cooling_method_name',
            'cooling_method_description',
            'is_active',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['cooling_method_name']
        ]
    ],

    'customer' => [
        'table' => 'precise.customer',
        'primary_key' => 'customer_id',
        'default_alias' => 'c',
        'columns' => [
            'customer_id',
            'customer_code',
            'customer_name',
            'customer_alias_name',
            'company_type_id',
            'retail_type_id',
            'npwp',
            'pkp_name',
            'fg_credit_limit',
            'fg_credit_term',
            'discount_type',
            'ppn_type',
            'head_office',
            'city_id',
            'ar_coa_id',
            'ar_sub_ledger_acc',
            'ar_response_code',
            'pdc_sub_ledger_acc',
            'pdc_response_code',
            'sa_sub_ledger_acc',
            'sa_response_code',
            'fg_clt_ppn',
            'fg_pet',
            'fg_customer_type',
            'fg_article',
            'fg_tax_form',
            'fg_kbn',
            'fg_bi',
            'fg_pph22',
            'price_group_code',
            'disc_group_code',
            'disc_1',
            'disc_2',
            'disc_3',
            'customer_description',
            'customer_old_id',
            'is_active',
            'approval_status',
            'approved_by',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['customer_name']
        ]
    ],

    'customer_address' => [
        'table' => 'precise.customer_address',
        'primary_key' => 'customer_address_id',
        'default_alias' => 'ca',
        'columns' => [
            'customer_address_id',
            'customer_id',
            'address_type_id',
            'is_default',
            'address',
            'subdistrict',
            'district',
            'city_id',
            'zipcode',
            'phone_number',
            'fax_number',
            'email',
            'website',
            'off_hour',
            'contact_person',
            'religion',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['address_type_id', 'customer_id']
        ]
    ],

    'country' => [
        'table' => 'precise.country',
        'primary_key' => 'country_id',
        'default_alias' => 'cy',
        'columns' => [
            'country_id',
            'country_code',
            'country_name',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['country_code'],
            ['country_name']
        ]
    ],
    'driver' => [
        'table' => 'precise.driver',
        'primary_key' => 'driver_nik',
        'default_alias' => 'd',
        'columns' => [
            'driver_nik',
            'is_active',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['driver_nik']
        ]
    ],
    'machine_injection' => [
        'table' => 'precise.machine_injection',
        'primary_key' => 'machine_injection_id',
        'default_alias' => 'mi',
        'columns' => [
            'machine_injection_id',
            'machine_code',
            'old_machine_code',
            'line_code',
            'line_number',
            'tonnage',
            'serial_number',
            'production_year',
            'brand',
            'motor_power',
            'heater_power',
            'machine_status_code',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['machine_code'],
            ['line_code', 'line_number']
        ]
    ],
    'machine_pressing' => [
        'table' => 'precise.machine_pressing',
        'primary_key' => 'machine_pressing_id',
        'default_alias' => 'mp',
        'columns' => [
            'machine_pressing_id',
            'machine_code',
            'old_machine_code',
            'machine_location',
            'line_code',
            'line_number',
            'tonnage',
            'serial_number',
            'production_year',
            'brand',
            'motor_power',
            'heater_power',
            'can_plain',
            'can_print',
            'can_mug',
            'can_bico_lg',
            'can_bico_material',
            'priority_rank',
            'machine_status_code',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['machine_code'],
            ['line_code', 'line_number']
        ]
    ],
    'machine_status' => [
        'table' => 'precise.machine_status',
        'primary_key' => 'status_code',
        'default_alias' => 'ms',
        'columns' => [
            'status_code',
            'status_description',
            'is_active',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by',
        ],
        'exists' => [
            ['status_code']
        ]
    ],
    'mold_injection' => [
        'master' => [
            'table' => 'precise.mold_injection_hd',
            'primary_key' => 'mold_injection_hd_id',
            'default_alias' => 'mihd',
            'columns' => [
                'mold_injection_hd_id',
                'mold_number',
                'mmit_code_dont_use',
                'mold_name',
                'is_family_mold',
                'customer_id',
                'status_code',
                'remake_from',
                'production_date',
                'tonnage_std',
                'tonnage_min',
                'tonnage_max',
                'steel_type_id',
                'mold_making_id',
                'mold_maker',
                'cooling_method_id',
                'mold_description',
                'length',
                'width',
                'height',
                'dimension_uom',
                'plate_size_length',
                'plate_size_width',
                'plate_size_uom',
                'created_on',
                'created_by',
                'updated_on',
                'updated_by',
            ],
            'exists' => [
                ['mold_number', 'cavity_no'],
                ['mold_number', 'cavity_no', 'customer_id']
            ]
        ],
        'detail' => [
            'table' => 'precise.mold_injection_dt',
            'primary_key' => 'mold_injection_dt_id',
            'default_alias' => 'midt',
            'columns' => [
                'mold_injection_dt_id',
                'mold_injection_hd_id',
                'mold_number',
                'cavity_no',
                'cavity_name',
                'article_code',
                'tonnage_min',
                'tonnage_max',
                'cycle_time',
                'cycle_time_std',
                'cavity_life_cycle',
                'cavity_status_code',
                'created_on',
                'created_by',
                'updated_on',
                'updated_by',
            ],
            'cavity' => [
                'table' => 'precise.mold_injection_cavity',
                'primary_key' => 'mold_injection_cavity_id',
                'default_alias' => 'micv',
                'columns' => [
                    'mold_injection_cavity_id',
                    'mold_injection_dt_id',
                    'cavity_number',
                    'product_weight',
                    'product_weight_uom',
                    'is_active',
                    'created_on',
                    'created_by',
                    'updated_on',
                    'updated_by'
                ],
                'exists' => []
            ],
            'exists' => [
                ['mold_injection_hd_id', 'cavity_number']
            ]
        ]
    ],
    'mold_making' => [
        'table' => 'precise.mold_making',
        'primary_key' => 'mold_making_id',
        'default_alias' => 'mm',
        'columns' => [
            'mold_making_id',
            'estimation_number',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by',
        ],
        'exists' => []
    ],
    'mold_pressing' => [
        'master' => [
            'table' => 'precise.mold_pressing_hd',
            'primary_key' => 'mold_pressing_hd_id',
            'default_alias' => 'mphd',
            'columns' => [
                'mold_pressing_hd_id',
                'mold_number',
                'mold_code',
                'mold_group',
                'mold_rack',
                'mold_location',
                'item_code',
                'default_tonnage',
                'mold_description',
                'mold_status_code',
                'mold_parent_id',
                'production_date',
                'mold_making_id',
                'mold_maker',
                'created_on',
                'created_by',
                'updated_on',
                'updated_by'
            ],
            'exists' => [
                ['mold_code']
            ]
        ],
        'detail' => [
            'table' => 'precise.mold_pressing_dt',
            'primary_key' => 'mold_pressing_dt_id',
            'default_alias' => 'mpdt',
            'columns' => [
                'mold_pressing_dt_id',
                'mold_pressing_hd_id',
                'mold_code',
                'cavity_number',
                'product_weight',
                'product_weight_uom',
                'is_active',
                'created_on',
                'created_by',
                'updated_on',
                'updated_by'
            ],
            'exists' => [
                ['mold_pressing_hd_id', 'cavity_no']
            ]
        ]
    ],

    'mold_status' => [
        'table' => 'precise.mold_status',
        'primary_key' => 'status_code',
        'default_alias' => 'ms',
        'columns' => [
            'status_code',
            'status_description',
            'is_active',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by',
        ],
        'exists' => [
            ['status_code']
        ]
    ],

    'packaging' => [
        'master' => [
            'table' => 'precise.packaging_hd',
            'primary_key' => 'packaging_id',
            'default_alias' => 'phd',
            'columns' => [
                'packaging_id',
                'packaging_alias',
                'inner_length',
                'inner_width',
                'inner_height',
                'outer_length',
                'outer_width',
                'outer_height',
                'dimension_uom_code',
                'weight',
                'weight_uom_code',
                'packaging_spec',
                'max_stack',
                'created_on',
                'created_by',
                'updated_on',
                'updated_by'
            ],
            'exists' => [
                ['packaging_code']
            ]
        ],
        'detail' => [
            'table' => 'precise.packaging_dt',
            'primary_key' => 'packaging_dt_id',
            'default_alias' => 'pdt',
            'columns' => [
                'packaging_dt_id',
                'packaging_id',
                'product_id',
                'item_id',
                'item_code',
                'product_qty',
                'priority',
                'usage_per_unit',
                'created_on',
                'created_by',
                'updated_on',
                'updated_by'
            ],
            'exists' => [
                ['packaging_hd_id', 'cavity_no']
            ]
        ]
    ],
    'product' => [
        'table' => 'precise.product',
        'primary_key' => 'product_id',
        'default_alias' => 'p',
        'columns' => [
            'product_id',
            'product_code',
            'product_name',
            'product_group_id',
            'default_packaging_id',
            'product_description',
            'product_status_code',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['product_code']
        ]
    ],
    'product_brand' => [
        'table' => 'precise.product_brand',
        'primary_key' => 'product_brand_id',
        'default_alias' => 'pb',
        'columns' => [
            'product_brand_id',
            'product_brand_name',
            'is_active',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['product_brand_name']
        ]
    ],
    'product_equivalent' => [
        'table' => 'precise.product_equivalent',
        'primary_key' => 'equivalent_id',
        'default_alias' => 'pe',
        'columns' => [
            'equivalent_id',
            'product_code',
            'uom_code',
            'qty_std',
            'qty_conversion',
            'updated_by',
            'updated_on',
        ],
        'exists' => []
    ],
    'state' => [
        'table' => 'precise.state',
        'primary_key' => 'state_id',
        'default_alias' => 's',
        'columns' => [
            'state_id',
            'state_code',
            'state_name',
            'country_id',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['state_code'],
            ['state_name']
        ]
    ],
    'steel_type' => [
        'table' => 'precise.steel_type',
        'primary_key' => 'steel_type_id',
        'default_alias' => 'st',
        'columns' => [
            'steel_type_id',
            'steel_type_name',
            'is_active',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['steel_type_name']
        ]
    ],
    'supplier' => [
        'table' => 'precise.supplier',
        'primary_key' => 'supplier_id',
        'default_alias' => 's',
        'columns' => [
            'supplier_id',
            'supplier_code',
            'supplier_name',
            'supplier_alias_name',
            'origin',
            'supplier_group_code',
            'company_type_id',
            'supplier_addr1',
            'supplier_addr2',
            'city_id',
            'supplier_zip_code',
            'supplier_phone1',
            'supplier_phone2',
            'supplier_phone3',
            'supplier_fax1',
            'supplier_fax2',
            'supplier_email',
            'supplier_website',
            'npwp',
            'pkp_name',
            'ppn_type',
            'supplier_credit_term',
            'supplier_credit_limit',
            'ap_coa_id',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['supplier_code'],
            ['supplier_name']
        ]
    ],
    'uom' => [
        'table' => 'precise.uom',
        'primary_key' => 'uom_code',
        'default_alias' => 'u',
        'columns' => [
            'uom_code',
            'uom_name',
            'is_active',
            'created_by',
            'created_on',
            'updated_by',
            'updated_on',
        ],
        'exists' => [
            ['uom_code'],
            ['uom_name']
        ]
    ],
    'vehicle' => [
        'table' => 'precise.vehicle',
        'primary_key' => 'vehicle_id',
        'default_alias' => 'v',
        'columns' => [
            "vehicle_id",
            "vehicle_model",
            "license_number",
            "vehicle_description",
            "is_owned",
            "is_active",
            "created_on",
            "created_by",
            "updated_on",
            "updated_by"
        ],
        'exists' => [
            ['license_number']
        ]
    ],
    'warehouse' => [
        'table' => 'precise.warehouse',
        'primary_key' => 'warehouse_id',
        'default_alias' => 'wh',
        'columns' => [
            'warehouse_id',
            'warehouse_code',
            'warehouse_name',
            'warehouse_alias',
            'warehouse_group_code',
            'is_active',
            'warehouse_pic_1',
            'warehouse_pic_2',
            'warehouse_approver',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['warehouse_code'],
            ['warehouse_name'],
            ['warehouse_alias']
        ]
    ],
    'warehouse_group' => [
        'table' => 'precise.warehouse_group',
        'primary_key' => 'warehouse_group_code',
        'default_alias' => 'wg',
        'columns' => [
            'warehouse_group_code',
            'warehouse_group_name',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['warehouse_group_code']
        ]
    ],
    'workcenter' => [
        'table' => 'precise.workcenter',
        'primary_key' => 'workcenter_id',
        'default_alias' => 'wc',
        'columns' => [
            'workcenter_id',
            'workcenter_code',
            'workcenter_name',
            'workcenter_description',
            'default_warehouse',
            'is_active',
            'production_type',
            'production_center',
            'subprocess_level',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => [
            ['workcenter_code'],
            ['workcenter_name']
        ]
    ]
];
