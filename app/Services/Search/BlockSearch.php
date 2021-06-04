<?php

declare(strict_types=1);

namespace App\Services\Search;

use App\Contracts\Search;
use App\Facades\Wallets;
use App\Models\Block;
use App\Models\Composers\TimestampRangeComposer;
use App\Models\Composers\ValueRangeComposer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Throwable;
use App\Services\Search\Traits\ValidatesTerm;

final class BlockSearch implements Search
{
    const INT4_MAXVALUE = 2147483647;

    use ValidatesTerm;

    public function search(array $parameters): Builder
    {
        $query = Block::query();

        $this->applyScopes($query, $parameters);

        $term = Arr::get($parameters, 'term');

        if (! is_null($term)) {
            if ($this->couldBeABlockID($term)) {
                $query = $query->whereLowerEqual('id', $term);
            } else {
                // Forces empty results when it has a term but not possible results
                return $query->empty();
            }

            if ($this->isOnlyNumbers($term) && $this->numericRangeIsInRange($term)) {
                $query->orWhere('height', $term);
            }

            try {
                // If there is a term we also want to check if the term is a valid wallet.
                $query->orWhere(function ($query) use ($parameters, $term): void {
                    $wallet = Wallets::findByIdentifier($term);

                    $query->whereLowerEqual('generator_public_key', $wallet->public_key);

                    $this->applyScopes($query, $parameters);
                });
            } catch (Throwable) {
                // If this throws then the term was not a valid address, public key or username.
            }
        }

        return $query;
    }

    /**
     * Validates that the numnber is smaller that the max size for a type integer
     * on pgsql. Searching for a bigger number will result in an SQL exception
     *
     * @return bool
     */
    private function numericRangeIsInRange(string $term): bool
    {
        return floatval($term) <= static::INT4_MAXVALUE;
    }

    private function applyScopes(Builder $query, array $parameters): void
    {
        ValueRangeComposer::compose($query, $parameters, 'height', false);

        ValueRangeComposer::compose($query, $parameters, 'total_amount');

        ValueRangeComposer::compose($query, $parameters, 'total_fee');

        ValueRangeComposer::compose($query, $parameters, 'reward');

        TimestampRangeComposer::compose($query, $parameters);

        if (! is_null(Arr::get($parameters, 'generatorPublicKey'))) {
            $query->whereLowerEqual('generator_public_key', $parameters['generatorPublicKey']);
        }
    }
}
