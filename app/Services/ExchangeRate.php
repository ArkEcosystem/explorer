<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

final class ExchangeRate
{
    public static function convert(float $amount, int $timestamp): string
    {
        $prices       = Cache::get('prices.'.Settings::currency());
        $exchangeRate = $prices[Carbon::parse(static::timestamp($timestamp))->format('Y-m-d')];

        return NumberFormatter::currency($amount * $exchangeRate, Settings::currency());
    }

    private static function timestamp(int $timestamp): Carbon
    {
        return Timestamp::fromGenesis($timestamp);
    }
}
