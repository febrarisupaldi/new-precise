<?php

use App\Database\Schema\Table;
use App\Database\Schema\TableFactory;

if (!function_exists('table')) {
    function table(string $module, string $resource): Table
    {
        return TableFactory::make($module, $resource);
    }
}
