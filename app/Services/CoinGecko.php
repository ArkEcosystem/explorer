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
                'days' => 'max',
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
            $result = Http::get('https://min-api.cryptocompare.com/data/histohour', [
                'fsym'  => $source,
                'tsym'  => $target,
                'toTs'  => Carbon::now()->unix(),
                'limit' => $limit,
            ])->json()['Data'];

            return collect($result)
                ->groupBy(fn ($day) => Carbon::createFromTimestamp($day['time'])->format($format))
                ->mapWithKeys(fn ($transactions, $day) => [
                    $day => ResolveScientificNotation::execute($transactions->sum('close')),
                ]);
        });
    }

    public function getCurrenciesData(string $source, Collection $targets): Collection
    {
        $result = Http::get('https://min-api.cryptocompare.com/data/pricemultifull', [
            'fsyms'  => $source,
            'tsyms'  => $targets->join(','),
        ])->json();

        return $targets->mapWithKeys(fn ($currency) => [
            strtoupper($currency) => [
                    'priceChange' => Arr::get($result, 'RAW.'.$source.'.'.strtoupper($currency).'.CHANGEPCT24HOUR', 0) / 100,
                    'price'       => Arr::get($result, 'RAW.'.$source.'.'.strtoupper($currency).'.PRICE', 0),
                ],
            ]);
    }
}
