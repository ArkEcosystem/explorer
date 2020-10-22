<?php

declare(strict_types=1);

namespace App\Services\Search;

use App\Contracts\Search;
use App\Models\Transaction;
use App\Services\Search\Concerns\FiltersDateRange;
use App\Services\Search\Concerns\FiltersValueRange;
use Illuminate\Database\Eloquent\Builder;

final class TransactionSearch implements Search
{
    use FiltersDateRange;
    use FiltersValueRange;

    public function search(array $parameters): Builder
    {
        $query = Transaction::query();

        $this->queryValueRange($query, $parameters['amountFrom'], $parameters['amountTo']);

        $this->queryValueRange($query, $parameters['feeFrom'], $parameters['feeTo']);

        $this->queryDateRange($query, $parameters['dateFrom'], $parameters['dateTo']);

        if ($parameters['smartBridge']) {
            $query->where('vendor_field_hex', $parameters['smartBridge']);
        }

        return $query;
    }
}
