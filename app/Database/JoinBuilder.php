<?php

namespace App\Database;

use App\Database\Schema\Table;
use Illuminate\Database\Query\Builder;

class JoinBuilder
{
    public static function leftJoin(
        Builder $query,
        Table $table,
        string $first,
        string $operator,
        string $second,
        ?callable $callback = null
    ): Builder {
        return $query->leftJoin(
            $table->from(),
            function ($join) use (
                $first,
                $operator,
                $second,
                $callback
            ) {
                $join->on(
                    $first,
                    $operator,
                    $second
                );

                if ($callback) {
                    $callback($join);
                }
            }
        );
    }

    public static function join(
        Builder $query,
        Table $table,
        string $first,
        string $operator,
        string $second,
        ?callable $callback = null
    ): Builder {
        return $query->join(
            $table->from(),
            function ($join) use (
                $first,
                $operator,
                $second,
                $callback
            ) {
                $join->on(
                    $first,
                    $operator,
                    $second
                );

                if ($callback) {
                    $callback($join);
                }
            }
        );
    }

    public static function rightJoin(
        Builder $query,
        Table $table,
        string $first,
        string $operator,
        string $second,
        ?callable $callback = null
    ): Builder {
        return $query->rightJoin(
            $table->from(),
            function ($join) use (
                $first,
                $operator,
                $second,
                $callback
            ) {
                $join->on(
                    $first,
                    $operator,
                    $second
                );

                if ($callback) {
                    $callback($join);
                }
            }
        );
    }
}
