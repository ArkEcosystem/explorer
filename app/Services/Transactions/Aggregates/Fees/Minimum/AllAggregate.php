<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Minimum;

use App\Models\Transaction;
use App\Services\BigNumber;
use App\Services\Transactions\Aggregates\Concerns\HasQueries;

final class AllAggregate
{
    use HasQueries;

    private ?string $type;

    public function __construct(?string $type = null)
    {
        $this->type = $type;
    }

    public function aggregate(): float
    {
        $scope = $this->getScopeByType($this->type);

        return BigNumber::new(
            Transaction::query()
                ->when($scope, fn ($query) => $query->withScope($scope))
                ->min('fee') ?? 0
        )->toFloat();
    }
}
