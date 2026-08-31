<?php

return [
    'machine_pressing_activity' => [
        'table' => 'precise.machine_pressing_activity',
        'primary_key' => 'machine_pressing_activity_id',
        'default_alias' => 'mpa',
        'columns' => [
            'machine_pressing_activity_id',
            'machine_pressing_id',
            'mold_pressing_hd_id',
            'activity_date',
            'trans_date',
            'shift',
            'activity_location',
            'setter_mold_nik',
            'machine_status_code',
            'mold_status_code',
            'description',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => []
    ],
    'mold_pressing_activity' => [
        'table' => 'precise.mold_pressing_activity',
        'primary_key' => 'mold_pressing_activity_id',
        'default_alias' => 'mpa',
        'columns' => [
            'mold_pressing_activity_id',
            'mold_pressing_hd_id',
            'activity_date',
            'activity_type',
            'location',
            'description',
            'created_on',
            'created_by',
            'updated_on',
            'updated_by'
        ],
        'exists' => []
    ]
];
