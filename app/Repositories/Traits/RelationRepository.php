<?php

namespace App\Repositories\Traits;

use App\Repositories\BaseRepository;
use Illuminate\Database\Query\Builder;

trait RelationRepository
{
    public function belongsTo(
        Builder $query,
        BaseRepository $repository,
        string $foreignKey,
        ?string $joinAlias = null
    ): Builder {

        $alias = $joinAlias ?? $repository->getAlias();

        return $query->join(
            "{$repository->getTable()} as {$alias}",
            "{$alias}.{$repository->getPrimaryKey()}",
            '=',
            $foreignKey
        );
    }

    public function leftBelongsTo(
        Builder $query,
        BaseRepository $repository,
        string $foreignKey,
        ?string $joinAlias = null
    ): Builder {

        $alias = $joinAlias ?? $repository->getAlias();

        return $query->leftJoin(
            "{$repository->getTable()} as {$alias}",
            "{$alias}.{$repository->getPrimaryKey()}",
            '=',
            $foreignKey
        );
    }
}
