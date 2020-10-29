<?php

declare(strict_types=1);

namespace App\Services\Transactions\Aggregates\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait HasPlaceholders
{
    private function mergeWithPlaceholders(Collection $aggregate, int $end, int $step, string $format): Collection
    {
        $result = [];

        foreach ($this->placeholders($end, $step, $format) as $key) {
            $result[$key] = Arr::get($aggregate, $key, 0);
        }

        return collect($result);
    }

    private function placeholders(int $end, int $step, string $format): array
    {
        $times = [];

        foreach (range(0, $end, $step) as $timestamp) {
            $times[] = gmdate($format, $timestamp);
        }

        /* @phpstan-ignore-next-line */
        return array_combine($times, $times);
    }
}
