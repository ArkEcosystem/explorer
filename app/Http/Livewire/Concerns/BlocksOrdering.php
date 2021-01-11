<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Models\Scopes\OrderByBlockAmountAscScope;
use App\Models\Scopes\OrderByBlockAmountDescScope;
use App\Models\Scopes\OrderByBlockFeeAscScope;
use App\Models\Scopes\OrderByBlockFeeDescScope;
use App\Models\Scopes\OrderByGeneratorPublicKeyAscScope;
use App\Models\Scopes\OrderByGeneratorPublicKeyDescScope;
use App\Models\Scopes\OrderByHeightAscScope;
use App\Models\Scopes\OrderByHeightDescScope;
use App\Models\Scopes\OrderByIdAscScope;
use App\Models\Scopes\OrderByIdDescScope;
use App\Models\Scopes\OrderByTimestampAscScope;
use App\Models\Scopes\OrderByTimestampDescScope;
use App\Models\Scopes\OrderByTransactionAmountAscScope;
use App\Models\Scopes\OrderByTransactionAmountDescScope;

trait BlocksOrdering
{
    public string $blocksOrdering          = OrderingTypeEnum::HEIGHT;

    public string $blocksOrderingDirection = OrderingDirectionEnum::DESC;

    public function orderBlocksBy(string $value): void
    {
        $this->blocksOrdering = $value;

        $this->blocksOrderingDirection = $this->blocksOrderingDirection === OrderingDirectionEnum::DESC ? OrderingDirectionEnum::ASC : OrderingDirectionEnum::DESC;
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'id'           => ['asc' => OrderByIdAscScope::class, 'desc' => OrderByIdDescScope::class],
            'timestamp'    => ['asc' => OrderByTimestampAscScope::class, 'desc' => OrderByTimestampDescScope::class],
            'generated_by' => ['asc' => OrderByGeneratorPublicKeyAscScope::class, 'desc' => OrderByGeneratorPublicKeyDescScope::class],
            'height'       => ['asc' => OrderByHeightAscScope::class, 'desc' => OrderByHeightDescScope::class],
            'transactions' => ['asc' => OrderByTransactionAmountAscScope::class, 'desc' => OrderByTransactionAmountDescScope::class],
            'amount'       => ['asc' => OrderByBlockAmountAscScope::class, 'desc' => OrderByBlockAmountDescScope::class],
            'fee'          => ['asc' => OrderByBlockFeeAscScope::class, 'desc' => OrderByBlockFeeDescScope::class],
        ];

        return $scopes[$this->blocksOrdering][$this->blocksOrderingDirection];
    }
}
