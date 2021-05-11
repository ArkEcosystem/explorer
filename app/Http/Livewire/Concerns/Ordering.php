<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\OrderingDirectionEnum;

trait Ordering
{
    public function renderDirectionIcon(string $value): string
    {
        $value = substr($value, ((int) strrpos($value, '.')) + 1);

        if ($value === $this->ordering) {
            if ($this->orderingDirection === OrderingDirectionEnum::DESC) {
                return 'chevron-down';
            }

            return 'chevron-up';
        }

        return 'chevron-down';
    }
}
