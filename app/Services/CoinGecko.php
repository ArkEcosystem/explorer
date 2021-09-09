<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use App\Facades\Network;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Contracts\CryptoDataFetcher;
use Illuminate\Support\Facades\Http;
use App\Services\Cache\CryptoDataCache;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Konceiver\BetterNumberFormatter\ResolveScientificNotation;

final class CoinGecko implements CryptoDataFetcher
{
    public function historical(string $source, string $target, string $format = 'Y-m-d'): Collection
    {
        return (new CryptoDataCache())->setHistorical($source, $target, $format, function () use ($source, $target, $format): Collection {
            $client = new CoinGeckoClient();

            $params = [
                'vs_currency' => Str::lower($target),
                'days' => Network::epoch()->diffInDays(),
                'interval' => 'daily',
            ];

            $data = $client->coins()->get('/coins/' . Str::lower($source) . '/market_chart', $params);

            return collect($data['prices'])
                ->mapWithKeys(fn ($item) => [Carbon::createFromTimestampMs($item[0])->format($format) => $item[1]]);
        });
    }

    public function historicalHourly(string $source, string $target, int $limit = 23, string $format = 'Y-m-d H:i:s'): Collection
    {
        return (new CryptoDataCache())->setHistoricalHourly($source, $target, $format, $limit, function () use ($source, $target, $format, $limit): Collection {
            $client = new CoinGeckoClient();

            $data = $client->coins()->getMarketChart(
                Str::lower($source),
                Str::lower($target),
                strval(ceil($limit / 24))
            );

            return collect($data['prices'])
                ->groupBy(fn ($item) => Carbon::createFromTimestampMsUTC($item[0])->format('Y-m-d H:') . '00:00')
                ->mapWithKeys(fn ($items, $day) => [
                    Carbon::createFromFormat('Y-m-d H:i:s', $day)->format($format) => collect($items)->average(fn ($item) => $item[1])
                ])
                // Take the last $limit items (since the API returns a whole days and the limit is per hour)
                ->reverse()->take($limit + 1)->reverse();
        });
    }

    // @TODO
    public function getCurrenciesData(string $source, Collection $targets): Collection
    {
        return collect();
        // $client = new CoinGeckoClient();

        // $data = $client->coins()->getMarkets(
        //     'Str::lower($source)',
        //     [
        //         'ids' => $targets->map(fn ($target) => Str::lower($target))->join(','),
        //     ]
        // );

        // dd

        // $result = Http::get('https://min-api.cryptocompare.com/data/pricemultifull', [
        //     'fsyms'  => $source,
        //     'tsyms'  => $targets->join(','),
        // ])->json();

        // return $targets->mapWithKeys(fn ($currency) => [
        //     strtoupper($currency) => [
        //             'priceChange' => Arr::get($result, 'RAW.'.$source.'.'.strtoupper($currency).'.CHANGEPCT24HOUR', 0) / 100,
        //             'price'       => Arr::get($result, 'RAW.'.$source.'.'.strtoupper($currency).'.PRICE', 0),
        //         ],
        //     ]);
    }
}
