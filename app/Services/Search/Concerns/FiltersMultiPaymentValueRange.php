<?php

declare( strict_types=1 );

namespace App\Services\Search\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

trait FiltersMultiPaymentValueRange {
    /**
     * @param Builder $query
     * @param string|int|null $from
     * @param string|int|null $to
     * @param bool $useSatoshi
     *
     * @return Builder
     */
    private function queryMultiPaymentValueRange( Builder $query, $from, $to, bool $useSatoshi = true ): Builder {
        if ( is_null( $from ) && is_null( $to ) ) {
            return $query;
        }

        $query->where( 'amount', '=', 0 );

        $query->whereExists( function ( \Illuminate\Database\Query\Builder $qq ) use ( $useSatoshi, $to, $from ) {
            $qq->selectRaw( "i.id" )
               ->fromRaw( DB::raw( "( SELECT id, (jsonb_array_elements(asset -> 'payments') ->> 'amount')::bigint am FROM transactions t WHERE t.id = id ) i" ) )
               ->whereRaw( 'i.id = transactions.id' )
               ->groupBy( 'i.id' )
               ->when( ! is_null( $from ) && $from > 0, function ( $q ) use ( $useSatoshi, $from ) {
                   $q->havingRaw( 'sum(am) >= ?', [
                       $from * ( $useSatoshi ? 1e8 : 1 )
                   ] );
               } )
               ->when( ! is_null( $to ) && $to > 0, function ( $q ) use ( $useSatoshi, $to ) {
                   $q->havingRaw( 'sum(am) <= ?', [
                       $to * ( $useSatoshi ? 1e8 : 1 )
                   ] );
               } );
        } );

        return $query;
    }
}
