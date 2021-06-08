<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait HasEmptyScope
{
    /**
     * Used to force a query with no results.
     */
    public function scopeEmpty(Builder $query): Builder
    {
        return $query->where(DB::raw('false'));
    }
}
