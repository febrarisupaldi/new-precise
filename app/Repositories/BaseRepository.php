<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

abstract class BaseRepository
{
    protected $table;

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
     * @return \Illuminate\Support\Collection
     */
    public function all(): Collection
    {
        return $this->query()->get();
    }

    /**
     * Find record by ID
     *
     * @param mixed $id
     * @param string $column
     * @return object|null
     */
    public function find($id, $column = 'id'): ?object
    {
        return $this->query()->where($column, $id)->first();
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
    public function delete($id, string $primaryKey, string $updatedBy, string $reason): int
    {
        $this->setAuditSession($updatedBy, $reason);
        return $this->query()->where($primaryKey, $id)->delete();
    }
}
