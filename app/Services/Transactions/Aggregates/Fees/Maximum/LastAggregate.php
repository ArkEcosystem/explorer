<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Maximum;

use App\Models\Transaction;
use App\Services\BigNumber;
use App\Services\Transactions\Aggregates\Concerns\HasQueries;

final class LastAggregate
{
    use HasQueries;

    private string $type;

    private int $limit = 20;

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function aggregate(): float
    {
        $scope = $this->getScopeByType($this->type);

        return BigNumber::new(
            Transaction::select(['id', 'fee'])
                ->withScope($scope)
                ->latest('timestamp')
                ->take($this->limit)
                ->max('fee') ?? 0
        )->toFloat();
    }
}
