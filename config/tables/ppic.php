<?php

return [
    "material_usage" => [
        "table" => "precise.material_usage",
        "alias" => "mu",
        "primaryKey" => "material_usage_id",
        "columns" => [
            "usage_id",
            "work_order_hd_id",
            "PrdNumber",
            "PrdSeq",
            "production_date",
            "usage_description",
            "material_id",
            "material_qty",
            "material_uom",
            "material_std_qty",
            "material_std_uom",
            "bom_hd_id",
            "bom_factor",
            "warehouse_id",
            "InvtNmbr",
            "InvtType",
            "trans_hd_id",
            "created_on",
            "created_by",
            "updated_on",
            "updated_by"
        ],
        "exists" => []
    ]
];
