<?php

declare(strict_types=1);

namespace App\Actions;

use App\Facades\Network;
use App\Models\Block;

final class AggregateRoundPerformanceByPublicKey
{
    public static function execute(int $round, string $publicKey): array
    {
        return collect(range($round - 6, $round - 2))->mapWithKeys(function ($round): array {
            $roundStart = (int) $round * Network::delegateCount();

            return [
                $round => [
                    'min' => $roundStart,
                    'max' => $roundStart + (Network::delegateCount() - 1),
                ],
            ];
        })->map(function ($round) use ($publicKey): bool {
            return Block::query()
                ->where('generator_public_key', $publicKey)
                ->whereBetween('height', [$round['min'], $round['max']])
                ->count() > 0;
        })->values()->toArray();
    }
}
