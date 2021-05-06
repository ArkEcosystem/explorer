<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\OrderingDirectionEnum;
use App\Enums\OrderingTypeEnum;
use App\Models\Scopes\OrderByAddressAscScope;
use App\Models\Scopes\OrderByAddressDescScope;
use App\Models\Scopes\OrderByBalanceAscScope;
use App\Models\Scopes\OrderByBalanceDescScope;
use App\Models\Scopes\OrderBySupplyAscScope;
use App\Models\Scopes\OrderBySupplyDescScope;

trait WalletsOrdering
{
    public string $walletsOrdering          = OrderingTypeEnum::BALANCE;

    public string $walletsOrderingDirection = OrderingDirectionEnum::DESC;

    public function orderWalletsBy(string $value): void
    {
        $this->walletsOrdering = $value;

        $this->walletsOrderingDirection = $this->walletsOrderingDirection === OrderingDirectionEnum::DESC ? OrderingDirectionEnum::ASC : OrderingDirectionEnum::DESC;
    }

    public function renderDirectionIcon(string $value): string
    {
        $value = substr($value, ((int) strrpos($value, '.')) + 1);

        if ($value === $this->walletsOrdering) {
            if ($this->walletsOrderingDirection === OrderingDirectionEnum::DESC) {
                return 'chevron-down';
            }

            return 'chevron-up';
        }

        return 'chevron-down';
    }

    private function getOrderingScope(): string
    {
        $scopes = [
            'address' => ['asc' => OrderByAddressAscScope::class, 'desc' => OrderByAddressDescScope::class],
            'balance' => ['asc' => OrderByBalanceAscScope::class, 'desc' => OrderByBalanceDescScope::class],
            'supply'  => ['asc' => OrderBySupplyAscScope::class, 'desc' => OrderBySupplyDescScope::class],
        ];

        return $scopes[$this->walletsOrdering][$this->walletsOrderingDirection];
    }
}
