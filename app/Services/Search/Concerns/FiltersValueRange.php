<?php

declare(strict_types=1);

namespace App\Services\Search\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait FiltersValueRange
{
    /** @phpstan-ignore-next-line */
    private function queryValueRange(Builder $query, string $column, ?int $from, ?int $to): Builder
    {
        if (! is_null($from) && ! is_null($to)) {
            $query->whereBetween($column, [$from, $to]);
        } elseif (! is_null($from)) {
            $query->where($column, '>=', $from);
        } elseif (! is_null($to)) {
            $query->where($column, '<=', $to);
        }

        return $query;
    }
}
