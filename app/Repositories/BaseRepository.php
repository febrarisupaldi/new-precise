<?php

namespace App\Repositories;

use App\Database\Schema\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use InvalidArgumentException;

abstract class BaseRepository
{

    protected Table $table;

    public function all(): Builder
    {
        return DB::table($this->table->from(), $this->table->alias())
            ->select($this->table->columns());
    }

    public function find(int|string $id): Builder
    {
        return $this->all()->where($this->table->pk(), $id);
    }

    public function findByColumn(array $conditions): Builder
    {
        return $this->all()->where($conditions);
    }

    public function procedure(string $query, array $paremeter): mixed
    {
        return DB::select($query, $paremeter);
    }

    public function insert(array $data): int
    {
        return DB::table(preg_replace('/\s+as\s+.+/i', '', $this->table->from()))
            ->insertGetId($data);
    }

    public function update(int|string $id, array $data): bool
    {
        return DB::table(preg_replace('/\s+as\s+.+/i', '', $this->table->from()))
            ->where($this->table->pk(), $id)
            ->update($data);
    }

    public function delete(int|string $id): bool
    {
        return DB::table(preg_replace('/\s+as\s+.+/i', '', $this->table->from()))
            ->where($this->table->pk(), $id)
            ->delete();
    }

    public function exists(array $conditions): bool
    {

        $columns = array_keys($conditions);

        sort($columns);

        $allowed = collect($this->table->existsConditions())
            ->map(function ($item) {
                sort($item);
                return $item;
            });

        if (!$allowed->contains($columns)) {
            throw new InvalidArgumentException('Condition is not allowed.');
        }

        return DB::table($this->table->from())
            ->where($conditions)
            ->exists();
    }

    public function lock(int|string $id): Builder
    {
        return $this->find($id)->lockForUpdate();
    }

    public function insertBatch(array $data): bool
    {
        return DB::table($this->table->from())
            ->insert($data);
    }

    public function setAuditSession(array $data): void
    {
        DB::statement("SET @updated_by = ?, @reason = ?", [$data['updated_by'], $data['reason']]);
    }

    // use RelationRepository;

    // protected string $table;
    // protected string $as;
    // protected string $primaryKey;
    // protected array $columns;
    // protected array $allowedExistsColumns;

    // public function qualify(string $column): string
    // {
    //     return "{$this->as}.{$column}";
    // }

    // public function qualifiedPrimaryKey(): string
    // {
    //     return $this->qualify($this->primaryKey);
    // }

    // public function withAlias(string $as): static
    // {
    //     $clone = clone $this;
    //     $clone->as = $as;

    //     return $clone;
    // }

    // public function select(string ...$columns): array
    // {
    //     return array_map(
    //         fn($column) => $this->qualify($column),
    //         $columns
    //     );
    // }

    // /**
    //  * Get all records
    //  *
    //  * @return \Illuminate\Database\Query\Builder
    //  */
    // public function all(): Builder
    // {
    //     return DB::table($this->table, $this->as)->select($this->columns);
    // }

    // /**
    //  * Find record by ID
    //  *
    //  * @param mixed $id
    //  * @return Builder
    //  */
    // public function find(int|string $id): Builder
    // {
    //     return DB::table($this->table, $this->as)->where($this->primaryKey, $id)->select($this->columns);
    // }

    // /**
    //  * Create a new record
    //  *
    //  * @param array $data
    //  * @return int
    //  */
    // public function insert(array $data): int
    // {
    //     return DB::table($this->table)->insertGetId($data);
    // }

    // /**
    //  * Lock a record
    //  * @param mixed $id
    //  * @return Builder
    //  */
    // public function lock(mixed $id): Builder
    // {
    //     return DB::table($this->table, $this->as)->where($this->primaryKey, $id)->lockForUpdate();
    // }

    // /**
    //  * Create multiple records
    //  *
    //  * @param array $data
    //  * @return bool
    //  */
    // public function insertBatch(array $data): bool
    // {
    //     return DB::table($this->table)->insert($data);
    // }

    // /**
    //  * Update a record with auditing
    //  * @param int $id
    //  * @param array $data
    //  * @param mixed $primaryKey
    //  * @return bool
    //  */
    // public function update(int $id, array $data, mixed $primaryKey = null): bool
    // {
    //     $primaryKey = $primaryKey ?? $this->primaryKey;
    //     return DB::table($this->table, $this->as)->where($primaryKey, $id)->update($data);
    // }

    // /**
    //  * Set MySQL session variables for auditing
    //  *
    //  * @param array $data
    //  * @return void
    //  */
    // public function setAuditSession(array $data): void
    // {
    //     DB::statement("SET @updated_by = ?, @reason = ?", [$data['updated_by'], $data['reason']]);
    // }

    // /**
    //  * Delete a record with auditing
    //  * @param int|string $id
    //  * @param array $data
    //  * @return bool
    //  */
    // public function delete(int|string $id, array $data): bool
    // {
    //     $this->setAuditSession($data);
    //     return DB::table($this->table, $this->as)->where($this->primaryKey, $id)->delete();
    // }

    // /**
    //  * Check if record exists
    //  *
    //  * @param array $conditions
    //  * @return bool
    //  */
    // public function exists(array $conditions): bool
    // {
    //     $columns = array_keys($conditions);

    //     sort($columns);

    //     $allowed = collect($this->allowedExistsColumns)
    //         ->map(function ($item) {
    //             sort($item);
    //             return $item;
    //         });

    //     if (!$allowed->contains($columns)) {
    //         throw new \InvalidArgumentException('Condition is not allowed.');
    //     }

    //     return DB::table($this->table, $this->as)
    //         ->where($conditions)
    //         ->exists();
    // }

    // public function removeAllColumns(): void
    // {
    //     $this->columns = [];
    // }

    // public function removeColumn(array $column): array
    // {
    //     return array_diff($this->columns, $column);
    // }
}
