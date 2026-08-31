<?php

namespace App\Database\Schema;

class Table
{
    public function __construct(
        protected string $table,
        protected string $alias,
        protected string $primaryKey,
        protected array $columns,
        protected array $exists
        //protected array $relations

    ) {}

    public function table(): string
    {
        return $this->table;
    }

    public function alias(): string
    {
        return $this->alias;
    }

    public function primaryKey(): string
    {
        return $this->primaryKey;
    }

    public function from(): string
    {
        return "{$this->table} as {$this->alias}";
    }

    public function qualify(string $column): string
    {
        return "{$this->alias}.{$column}";
    }

    public function pk(): string
    {
        return $this->qualify($this->primaryKey);
    }

    public function column(string $column): string
    {
        return $this->qualify($column);
    }

    public function columns(): array
    {
        return array_map(
            fn($column) => $this->qualify($column),
            $this->columns
        );
    }

    public function only(array $columns): array
    {
        return array_map(
            fn($column) => $this->column($column),
            $columns
        );
    }

    public function except(array $columns): array
    {
        return collect($this->columns())
            ->reject(function ($column) use ($columns) {
                return in_array(
                    str_replace($this->alias() . '.', '', $column),
                    $columns
                );
            })
            ->values()
            ->all();
    }

    public function existsConditions(): array
    {
        return $this->exists;
    }

    public function withAlias(string $alias): Table
    {
        return new Table(
            table: $this->table,
            alias: $alias,
            primaryKey: $this->primaryKey,
            columns: $this->columns,
            exists: $this->exists
            //relations: $this->relations
        );
    }
}
