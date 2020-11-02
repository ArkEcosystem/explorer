<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class CryptoCompareCache implements Contract
{
    use Concerns\ManagesCache;

    // public function getPrice(string $source, string $target): string
    // {
    //     return $this->get(sprintf('price.%s.%s', [$source, $target]));
    // }

    // public function setPrice(string $source, string $target, \Closure $callback): void
    // {
    //     $this->put(sprintf('price.%s.%s', [$source, $target]), $value);
    // }

    public function getPrices(string $currency): string
    {
        return $this->get(sprintf('prices.%s', [$currency]));
    }

    public function setPrices(string $currency, Collection $prices): void
    {
        $this->put(sprintf('prices.%s', [$currency]), $prices);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('crypto_compare');
    }
}
