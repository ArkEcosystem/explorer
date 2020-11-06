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

        $query->whereExists(function (\Illuminate\Database\Query\Builder $query) use ($useSatoshi, $to, $from): void {
            $query->selectRaw('i.id')
                ->fromRaw("( SELECT id, (jsonb_array_elements(asset -> 'payments') ->> 'amount')::bigint am FROM transactions t WHERE t.id = id ) i")
                ->whereRaw('i.id = transactions.id')
                ->groupBy('i.id');

            if (! is_null($from) && $from > 0) {
                $query->havingRaw('sum(am) >= ?', [
                    (int) $from * ($useSatoshi ? 1e8 : 1),
                ]);
            }

            if (! is_null($to) && $to > 0) {
                $query->havingRaw('sum(am) <= ?', [
                    (int) $to * ($useSatoshi ? 1e8 : 1),
                ]);
            }
        });

        return $query;
    }
}
