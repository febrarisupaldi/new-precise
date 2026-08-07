<?php

namespace App\Database\Schema;

use InvalidArgumentException;

class TableFactory
{
    public array $config;

    public static function make(string $module, string $resource): Table
    {
        $config = config("tables.{$module}.{$resource}");

        if (!$config) {
            throw new InvalidArgumentException("Config not found for {$module}.{$resource}");
        }

        return new Table(
            table: $config['table'],
            alias: $config['default_alias'],
            primaryKey: $config['primary_key'],
            columns: $config['columns'],
            exists: $config['exists']
            //relations: $config['relations'] ?? []
        );
    }
}
