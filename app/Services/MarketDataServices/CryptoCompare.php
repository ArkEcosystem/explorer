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
use Konceiver\BetterNumberFormatter\ResolveScientificNotation;

final class CryptoCompare implements MarketDataService
{
    public function historical(string $source, string $target, string $format = 'Y-m-d'): Collection
    {
        return (new CryptoDataCache())->setHistorical($source, $target, $format, function () use ($source, $target, $format): Collection {
            $result = Http::get('https://min-api.cryptocompare.com/data/histoday', [
                'fsym'  => $source,
                'tsym'  => $target,
                'toTs'  => Carbon::now()->unix(),
                'limit' => Network::epoch()->diffInDays(),
            ])->json()['Data'];

            return collect($result)
                ->groupBy(fn ($day) => Carbon::createFromTimestamp($day['time'])->format($format))
                ->mapWithKeys(fn ($transactions, $day) => [$day => $transactions->sum('close')]);
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