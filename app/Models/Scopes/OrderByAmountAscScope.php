<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\DB;

final class OrderByAmountAscScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->fromRaw('transactions t');
        $builder->selectRaw(DB::raw('t.*, d.list, COALESCE(d.list, t.amount) AS calc_amount'));
        $builder->crossJoin(DB::raw("LATERAL (
    SELECT sum((d->>'amount')::bigint) AS list
    FROM jsonb_array_elements(t.asset -> 'payments') AS d(elem)) d"));

        $builder->orderByRaw('COALESCE(d.list, t.amount) asc');
    }
}
