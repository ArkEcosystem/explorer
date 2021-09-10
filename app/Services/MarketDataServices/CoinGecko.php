<?php

declare(strict_types=1);

namespace App\Services\MarketDataServices;

use App\Contracts\MarketDataService;
use App\Facades\Network;
use App\Services\Cache\CryptoDataCache;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

final class CoinGecko implements MarketDataService
{
    public function historical(string $source, string $target, string $format = 'Y-m-d'): Collection
    {
        return (new CryptoDataCache())->setHistorical($source, $target, $format, function () use ($source, $target, $format): Collection {
            $params = [
                'vs_currency' => Str::lower($target),
                'days'        => Network::epoch()->diffInDays(),
                'interval'    => 'daily',
            ];

            $data = Http::get(
                'https://api.coingecko.com/api/v3/coins/'.Str::lower($source).'/market_chart',
                $params
            )->json();

            return collect($data['prices'])
                ->mapWithKeys(fn ($item) => [Carbon::createFromTimestampMs($item[0])->format($format) => $item[1]]);
        });
    }

    public function historicalHourly(string $source, string $target, int $limit = 23, string $format = 'Y-m-d H:i:s'): Collection
    {
        return (new CryptoDataCache())->setHistoricalHourly($source, $target, $format, $limit, function () use ($source, $target, $format, $limit): Collection {
            $params = [
                'vs_currency' => Str::lower($target),
                'days'        => strval(ceil($limit / 24)),
            ];

            $data = Http::get(
                'https://api.coingecko.com/api/v3/coins/'.Str::lower($source).'/market_chart',
                $params
            )->json();

            return collect($data['prices'])
                ->groupBy(fn ($item) => Carbon::createFromTimestampMsUTC($item[0])->format('Y-m-d H:').'00:00')
                ->mapWithKeys(fn ($items, $day) => [
                    /* @phpstan-ignore-next-line */
                    Carbon::createFromFormat('Y-m-d H:i:s', $day)->format($format) => collect($items)->average(fn ($item) => $item[1]),
                ])
                // Take the last $limit items (since the API returns a whole days and the limit is per hour)
                ->reverse()->take($limit + 1)->reverse();
        });
    }

    public function getCurrenciesData(string $source, Collection $targets): Collection
    {
        $data = Http::get('https://api.coingecko.com/api/v3/coins/'.Str::lower($source))->json();

        return $targets->mapWithKeys(fn (string $currency) => [strtoupper($currency) => [
            'priceChange' => Arr::get($data, 'market_data.price_change_24h_in_currency.'.Str::lower($currency)),
            'price'       => Arr::get($data, 'market_data.current_price.'.Str::lower($currency)),
        ]]);
    }
}
