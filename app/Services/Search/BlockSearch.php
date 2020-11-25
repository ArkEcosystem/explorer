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

final class BlockSearch implements Search
{
    public function search(array $parameters): Builder
    {
        $query = Block::query();

        $this->applyScopes($query, $parameters);

        $term = Arr::get($parameters, 'term');

        if (! is_null($term)) {
            $query = $query->whereLower('id', $term);

            if ($numericTerm = $this->getNumericTerm($term)) {
                $query->orWhere('height', $numericTerm);
            }

            try {
                // If there is a term we also want to check if the term is a valid wallet.
                $query->orWhere(function ($query) use ($parameters, $term): void {
                    $wallet = Wallets::findByIdentifier($term);

                    $query->whereLower('generator_public_key', $wallet->public_key);

                    $this->applyScopes($query, $parameters);
                });
            } catch (\Throwable $th) {
                // If this throws then the term was not a valid address, public key or username.
            }
        }

        return $query;
    }

    /**
     * Validate and normalize the term that may come as a string like
     * `"1,224,223"` or as number like `1224223`. If is not a valid numeric
     * value it return `false`.
     *
     * @param mixed $term search term
     *
     * @return mixed the filtered data, or FALSE if the filter fails.
     */
    private function getNumericTerm($term)
    {
        return filter_var($term, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_THOUSAND);
    }

    private function applyScopes(Builder $query, array $parameters): void
    {
        ValueRangeComposer::compose($query, $parameters, 'height', false);

        ValueRangeComposer::compose($query, $parameters, 'total_amount');

        ValueRangeComposer::compose($query, $parameters, 'total_fee');

        ValueRangeComposer::compose($query, $parameters, 'reward');

        TimestampRangeComposer::compose($query, $parameters);

        if (! is_null(Arr::get($parameters, 'generatorPublicKey'))) {
            $query->whereLower('generator_public_key', $parameters['generatorPublicKey']);
        }
    }
}
