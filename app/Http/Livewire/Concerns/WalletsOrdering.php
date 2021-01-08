<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Models\Scopes\OrderByAddressScope;
use App\Models\Scopes\OrderByBalanceScope;

trait WalletsOrdering
{
    public string $walletsOrdering          = 'balance';
    public string $walletsOrderingDirection = 'desc';

    public function orderWalletsBy(string $value): void
    {
        $this->walletsOrdering = $value;

        $this->walletsOrderingDirection = $this->walletsOrderingDirection === 'desc' ? 'asc' : 'desc';
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'address' => OrderByAddressScope::class,
            'balance' => OrderByBalanceScope::class,
            'supply'  => OrderByBalanceScope::class,
        ];

        return $scopes[$this->walletsOrdering];
    }
}
