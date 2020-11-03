<?php

declare(strict_types=1);

namespace App\Services\Search\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait FiltersValueRange
{
    /**
     * @param string|int|null $from
     * @param string|int|null $to
     */
    private function queryValueRange(Builder $query, string $column, $from, $to): Builder
    {
        if (is_null($from) && is_null($to)) {
            return $query;
        }

        if (! is_null($from) && $from > 0) {
            $query->where($column, '>=', $from * 1e8);
        }

        if (! is_null($to) && $to > 0) {
            $query->where($column, '<=', $to * 1e8);
        }

        return $query;
    }
}
