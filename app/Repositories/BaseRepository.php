<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class BaseRepository
{
    protected string $table;
    protected string $as;
    protected string $primaryKey;
    protected array $columns;

    /**
     * Get all records
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function all(): Builder
    {
        return DB::table($this->table, $this->as)->select($this->columns);
    }

    /**
     * Find record by ID
     *
     * @param mixed $id
     * @return Builder
     */
    public function find(int|string $id): Builder
    {
        return DB::table($this->table, $this->as)->where($this->primaryKey, $id)->select($this->columns);
    }

    /**
     * Create a new record
     *
     * @param array $data
     * @return int
     */
    public function insert(array $data): int
    {
        return DB::table($this->table)->insertGetId($data);
    }

    /**
     * Lock a record
     * @param mixed $id
     * @return Builder
     */
    public function lock(mixed $id): Builder
    {
        return DB::table($this->table, $this->as)->where($this->primaryKey, $id)->lockForUpdate();
    }

    /**
     * Create multiple records
     *
     * @param array $data
     * @return bool
     */
    public function insertBatch(array $data): bool
    {
        return DB::table($this->table)->insert($data);
    }

    /**
     * Update a record with auditing
     * @param int $id
     * @param array $data
     * @param mixed $primaryKey
     * @return bool
     */
    public function update(int $id, array $data, mixed $primaryKey = null): bool
    {
        $primaryKey = $primaryKey ?? $this->primaryKey;
        return DB::table($this->table, $this->as)->where($primaryKey, $id)->update($data);
    }

    /**
     * Set MySQL session variables for auditing
     *
     * @param array $data
     * @return void
     */
    public function setAuditSession(array $data): void
    {
        DB::statement("SET @updated_by = ?, @reason = ?", [$data['updated_by'], $data['reason']]);
    }

    /**
     * Delete a record with auditing
     * @param int|string $id
     * @param array $data
     * @return bool
     */
    public function delete(int|string $id, array $data): bool
    {
        $this->setAuditSession($data);
        return DB::table($this->table, $this->as)->where($this->primaryKey, $id)->delete();
    }

    /**
     * Check if record exists
     *
     * @param array $columns
     * @param array $value
     * @return bool
     */
    public function exists(array $columns, array $value): bool
    {
        if (count($columns) !== count($value)) {
            throw new \InvalidArgumentException('Columns and values must have the same number of elements.', 400);
        }

        $check = DB::table("INFORMATION_SCHEMA.COLUMNS")
            ->select('COLUMN_NAME')
            ->where('TABLE_SCHEMA', config('database.connections.mysql.database'))
            ->where('TABLE_NAME', str_replace("precise.", "", $this->table))
            ->whereIn('COLUMN_NAME', $columns)
            ->exists();

        if (!$check) {
            throw new \InvalidArgumentException('Not exists', 404);
        }

        $data = array_combine($columns, $value);
        return DB::table($this->table)->where($data)->exists();
    }

    public function removeColumn(array $column):array{
        return array_diff($this->columns, $column);
    }

    public function getTable(): string{
        return $this->table;
    }

    public function getColumns(): array{
        return $this->columns;
    }

    public function getAlias(): string{
        return $this->as;
    }

    public function setAlias(string $alias): void{
        $this->as = $alias;
        $getPrimaryKey = explode(".", $this->primaryKey);
        $this->primaryKey = $alias . "." . $getPrimaryKey[1];
    }

    public function getPrimaryKey(): string{
        return $this->primaryKey;
    }

    public function setPrimaryKey(string $column): void{
        $this->primaryKey = $column;
    }
}
