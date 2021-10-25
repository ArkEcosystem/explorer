<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\SettingsStorage;
use App\Services\Cache\CryptoDataCache;
use Carbon\Carbon;
use Illuminate\Support\Arr;

final class ExchangeRate
{
    public static function convert(float $amount, int $timestamp): string
    {
        $prices       = (new CryptoDataCache())->getPrices(app(SettingsStorage::class)->currency().'.week');
        $exchangeRate = Arr::get($prices, Carbon::parse(static::timestamp($timestamp))->format('Y-m-d'), 0);

        return NumberFormatter::currency($amount * $exchangeRate, app(SettingsStorage::class)->currency());
    }

    public static function now(): float
    {
        return (float) (new CryptoDataCache())->getPrices(app(SettingsStorage::class)->currency().'.day')->last();
    }

    private static function timestamp(int $timestamp): Carbon
    {
        return Timestamp::fromGenesis($timestamp);
    }
}
