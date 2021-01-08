<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Models\Scopes\OrderByBlockAmountScope;
use App\Models\Scopes\OrderByBlockFeeScope;
use App\Models\Scopes\OrderByGeneratorPublicKeyScope;
use App\Models\Scopes\OrderByHeightScope;
use App\Models\Scopes\OrderByIdScope;
use App\Models\Scopes\OrderByTimestampScope;
use App\Models\Scopes\OrderByTransactionsAmountScope;

trait BlocksOrdering
{
    public array $state = [
        'blocksOrdering'          => 'height',
        'blocksOrderingDirection' => 'desc',
    ];

    public function mountWithBlocksOrdering(): void
    {
        $this->state = array_merge([
            'blocksOrdering'          => 'height',
            'blocksOrderingDirection' => 'desc',
        ], request('state', []));
    }

    public function orderBlocksBy(string $value): void
    {
        $this->state['blocksOrdering'] = $value;

        $this->state['blocksOrderingDirection'] = $this->state['blocksOrderingDirection'] === 'desc' ? 'asc' : 'desc';

        $this->gotoPage(1);
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'id'           => OrderByIdScope::class,
            'timestamp'    => OrderByTimestampScope::class,
            'generated_by' => OrderByGeneratorPublicKeyScope::class,
            'height'       => OrderByHeightScope::class,
            'transactions' => OrderByTransactionsAmountScope::class,
            'amount'       => OrderByBlockAmountScope::class,
            'fee'          => OrderByBlockFeeScope::class,
        ];

        return $scopes[$this->state['blocksOrdering']];
    }
}
