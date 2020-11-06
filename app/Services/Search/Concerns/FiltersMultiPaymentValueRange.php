<?php

declare(strict_types=1);

namespace App\Services\Search\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait FiltersMultiPaymentValueRange
{
    /**
     * @param Builder         $query
     * @param string|int|null $from
     * @param string|int|null $to
     * @param bool            $useSatoshi
     *
     * @return Builder
     */
    private function queryMultiPaymentValueRange(Builder $query, $from, $to, bool $useSatoshi = true): Builder
    {
        if (is_null($from) && is_null($to)) {
            return $query;
        }

        $query->where('amount', '=', 0);

        $query->whereExists(function (\Illuminate\Database\Query\Builder $qq) use ($useSatoshi, $to, $from): void {
            $qq->selectRaw('i.id')
               ->fromRaw("( SELECT id, (jsonb_array_elements(asset -> 'payments') ->> 'amount')::bigint am FROM transactions t WHERE t.id = id ) i")
               ->whereRaw('i.id = transactions.id')
               ->groupBy('i.id')
               ->when(! is_null($from) && $from > 0, function ($q) use ($useSatoshi, $from): void {
                   $q->havingRaw('sum(am) >= ?', [
                       (int) $from * ($useSatoshi ? 1e8 : 1),
                   ]);
               })
               ->when(! is_null($to) && $to > 0, function ($q) use ($useSatoshi, $to): void {
                   $q->havingRaw('sum(am) <= ?', [
                       (int) $to * ($useSatoshi ? 1e8 : 1),
                   ]);
               });
        });

        return $query;
    }
}
