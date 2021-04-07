<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait QueryWithCalculatedAmount
{
    public function baseCalculatedAmountQuery(Builder $builder, string $direction = 'asc'): void
    {
        $builder->fromRaw('transactions t');
        $builder->selectRaw(DB::raw('t.*, d.list, COALESCE(d.list, t.amount) AS calc_amount'));
        $builder->crossJoin(DB::raw("LATERAL (
            SELECT sum((d->>'amount')::bigint) AS list
            FROM jsonb_array_elements(t.asset -> 'payments') AS d(elem)) d")
        );

        $builder->orderByRaw("COALESCE(d.list, t.amount) {$direction}");
    }
}
