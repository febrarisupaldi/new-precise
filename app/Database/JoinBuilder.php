<?php

namespace App\Database;

use App\Database\Schema\Table;
use Illuminate\Database\Query\Builder;

class JoinBuilder
{
    public static function join(
        Builder $query,
        Table $table,
        string $first,
        string $operator,
        string $second
    ): Builder {

        return $query->join(

            $table->from(),

            $first,

            $operator,

            $second

        );
    }

    public static function leftJoin(
        Builder $query,
        Table $table,
        string $first,
        string $operator,
        string $second
    ): Builder {

        return $query->leftJoin(

            $table->from(),

            $first,

            $operator,

            $second

        );
    }

    public static function rightJoin(
        Builder $query,
        Table $table,
        string $first,
        string $operator,
        string $second
    ): Builder {

        return $query->rightJoin(

            $table->from(),

            $first,

            $operator,

            $second

        );
    }
}
