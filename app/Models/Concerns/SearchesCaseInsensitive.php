<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait SearchesCaseInsensitive
{
    public function scopeWhereLower(Builder $query, string $key, string $value): Builder
    {
        return $query->where(DB::raw("lower($key)"), 'ilike', $value);
    }

    public function scopeOrWhereLower(Builder $query, string $key, string $value): Builder
    {
        return $query->orWhere(DB::raw("lower($key)"), 'ilike', $value);
    }
}
