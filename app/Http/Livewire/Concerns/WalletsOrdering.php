<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Models\Scopes\OrderByAddressScope;
use App\Models\Scopes\OrderByBalanceScope;

trait WalletsOrdering
{
    public array $state = [
        'walletsOrdering'          => 'balance',
        'walletsOrderingDirection' => 'desc',
    ];

    public function mountWithWalletsOrdering(): void
    {
        $this->state = array_merge([
            'walletsOrdering'          => 'balance',
            'walletsOrderingDirection' => 'desc',
        ], request('state', []));
    }

    public function orderWalletsBy(string $value): void
    {
        $this->state['walletsOrdering'] = $value;

        $this->state['walletsOrderingDirection'] = $this->state['walletsOrderingDirection'] === 'desc' ? 'asc' : 'desc';

        $this->gotoPage(1);
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'address' => OrderByAddressScope::class,
            'balance' => OrderByBalanceScope::class,
            'supply'  => OrderByBalanceScope::class,
        ];

        return $scopes[$this->state['walletsOrdering']];
    }
}
