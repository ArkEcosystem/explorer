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
    public string $delegatesOrdering          = OrderingTypeEnum::RANK;

    public string $delegatesOrderingDirection = OrderingDirectionEnum::ASC;

    public function orderDelegatesBy(string $value): void
    {
        $this->delegatesOrdering = $value;

        $this->delegatesOrderingDirection = $this->delegatesOrderingDirection === OrderingDirectionEnum::DESC ? OrderingDirectionEnum::ASC : OrderingDirectionEnum::DESC;
    }

    public function renderDirectionIcon(string $value): string
    {
        $value = substr($value, ((int) strrpos($value, '.')) + 1);

        if ($value === $this->delegatesOrdering) {
            if ($this->delegatesOrderingDirection === OrderingDirectionEnum::DESC) {
                return 'chevron-down';
            }

            return 'chevron-up';
        }

        return 'chevron-down';
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

        return $scopes[$this->delegatesOrdering][$this->delegatesOrderingDirection];
    }
}
