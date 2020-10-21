<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

final class CryptoCompare
{
    public static function price(string $source, string $target): float
    {
        return (float) Cache::remember('cryptocompare.price:'.$source.':'.$target, 1800, function () use ($source, $target): string {
            $result = Http::get('https://min-api.cryptocompare.com/data/price', [
                'fsym'  => $source,
                'tsyms' => $target,
            ])->json()[strtoupper($target)];

            return ResolveScientificNotation::execute($result);
        });
    }
}
