<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Fees\Average;

use App\Models\Transaction;
use App\Services\BigNumber;
use App\Services\Transactions\Aggregates\Concerns\HasQueries;

final class AllAggregate
{
    use HasQueries;

    private ?string $type;

    public function setType(?string $type = null): self
    {
        $this->type = $type;

        return $this;
    }

    public function aggregate(): float
    {
        $scope = $this->getScopeByType($this->type);

        return BigNumber::new(
            Transaction::query()
                ->when($scope, fn ($query) => $query->withScope($scope))
                ->avg('fee') ?? 0
        )->toFloat();
    }
}
