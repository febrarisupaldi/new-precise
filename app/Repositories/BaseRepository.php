<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class BaseRepository
{
    protected string $table;
    protected string $primaryKey;
    protected array $columns;

    /**
     * Get Query Builder for the table
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function query(): Builder
    {
        return DB::table($this->table);
    }

    /**
     * Get all records
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function all(): Builder
    {
        return $this->query()->select($this->columns);
    }

    /**
     * Find record by ID
     *
     * @param mixed $id
     * @return Builder
     */
    public function find(mixed $id): Builder
    {
        return $this->query()->where($this->primaryKey, $id)->select($this->columns);
    }

    /**
     * Create a new record
     *
     * @param array $dto
     * @return bool
     */
    public function create(array $data): bool
    {
        return $this->query()->insert($data);
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
        return DB::transaction(function () use ($id, $primaryKey, $data) {
            if (!$this->find($id, $primaryKey)) {
                return null;
            }

            $this->setAuditSession($data["updated_by"], $data["reason"]);
            return $this->query()->where($primaryKey, $id)->update($data);
        }, 5);
    }

    /**
     * Set MySQL session variables for auditing
     *
     * @param string $updatedBy
     * @param string $reason
     * @return void
     */
    protected function setAuditSession(string $updatedBy, string $reason): void
    {
        DB::statement("SET @updated_by = ?, @reason = ?", [$updatedBy, $reason]);
    }

    /**
     * Delete a record with auditing
     */
    public function delete(mixed $id, string $primaryKey, string $updatedBy, string $reason): int
    {
        $this->setAuditSession($updatedBy, $reason);
        return $this->query()->where($primaryKey, $id)->delete();
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
            throw new \InvalidArgumentException('Columns and values must have the same number of elements.');
        }

        $check = DB::table("INFORMATION_SCHEMA.COLUMNS")
            ->select('COLUMN_NAME')
            ->where('TABLE_SCHEMA', config('database.connections.mysql.database'))
            ->where('TABLE_NAME', $this->table)
            ->whereIn('COLUMN_NAME', $columns)
            ->exists();

        if (!$check) {
            throw new \InvalidArgumentException('Not exists');
        }

        $data = array_combine($columns, $value);
        return $this->query()->where($data)->exists();
    }
}
