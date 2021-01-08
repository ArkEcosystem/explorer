<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Models\Scopes\OrderByAddressScope;
use App\Models\Scopes\OrderByIdScope;
use App\Models\Scopes\OrderByRankScope;
use App\Models\Scopes\OrderByVoteScope;

trait DelegatesOrdering
{
    public string $delegatesOrdering          = 'rank';

    public string $delegatesOrderingDirection = 'asc';

    public function orderDelegatesBy(string $value): void
    {
        $this->delegatesOrdering = $value;

        $this->delegatesOrderingDirection = $this->delegatesOrderingDirection === 'desc' ? 'asc' : 'desc';
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'id'      => OrderByIdScope::class,
            'rank'    => OrderByRankScope::class,
            'address' => OrderByAddressScope::class,
            'votes'   => OrderByVoteScope::class,
        ];

        return $scopes[$this->delegatesOrdering];
    }
}
