<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Models\Scopes\OrderByAddressAscScope;
use App\Models\Scopes\OrderByAddressDescScope;
use App\Models\Scopes\OrderByProductivityAscScope;
use App\Models\Scopes\OrderByProductivityDescScope;
use App\Models\Scopes\OrderByRankAscScope;
use App\Models\Scopes\OrderByRankDescScope;
use App\Models\Scopes\OrderByStatusAscScope;
use App\Models\Scopes\OrderByStatusDescScope;
use App\Models\Scopes\OrderByVoteAscScope;
use App\Models\Scopes\OrderByVoteDescScope;

trait DelegatesOrdering
{
    use Ordering;

    public string $ordering          = OrderingTypeEnum::RANK;

    public string $orderingDirection = OrderingDirectionEnum::ASC;

    public function orderDelegatesBy(string $value): void
    {
        $this->ordering = $value;

        $this->orderingDirection = $this->orderingDirection === OrderingDirectionEnum::DESC ? OrderingDirectionEnum::ASC : OrderingDirectionEnum::DESC;
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'rank'         => ['asc' => OrderByRankAscScope::class, 'desc' => OrderByRankDescScope::class],
            'address'      => ['asc' => OrderByAddressAscScope::class, 'desc' => OrderByAddressDescScope::class],
            'votes'        => ['asc' => OrderByVoteAscScope::class, 'desc' => OrderByVoteDescScope::class],
            'status'       => ['asc' => OrderByStatusAscScope::class, 'desc' => OrderByStatusDescScope::class],
            'productivity' => ['asc' => OrderByProductivityAscScope::class, 'desc' => OrderByProductivityDescScope::class],
        ];

        return $scopes[$this->ordering][$this->orderingDirection];
    }
}
