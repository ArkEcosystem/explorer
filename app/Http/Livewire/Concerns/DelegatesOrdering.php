<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Models\Scopes\OrderByAddressAscScope;
use App\Models\Scopes\OrderByAddressDescScope;
use App\Models\Scopes\OrderByIdAscScope;
use App\Models\Scopes\OrderByIdDescScope;
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

    private function getOrderingScope(): string
    {
        $scopes = [
            'id'           => ['asc' => OrderByIdAscScope::class, 'desc' => OrderByIdDescScope::class],
            'rank'         => ['asc' => OrderByRankAscScope::class, 'desc' => OrderByRankDescScope::class],
            'address'      => ['asc' => OrderByAddressAscScope::class, 'desc' => OrderByAddressDescScope::class],
            'votes'        => ['asc' => OrderByVoteAscScope::class, 'desc' => OrderByVoteDescScope::class],
            'status'       => ['asc' => OrderByStatusAscScope::class, 'desc' => OrderByStatusDescScope::class],
            'productivity' => ['asc' => OrderByProductivityAscScope::class, 'desc' => OrderByProductivityDescScope::class],
        ];

        return $scopes[$this->delegatesOrdering][$this->delegatesOrderingDirection];
    }
}
