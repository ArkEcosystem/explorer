<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class CryptoCompareCache implements Contract
{
    use Concerns\ManagesCache;

    public function cryptoHistorical(string $source, string $target, string $format): string
    {
        return $this->cacheKey('historical.%s.%s.%s', [$source, $target, $format]);
    }

    public function cryptoPrice(string $source, string $target): string
    {
        return $this->cacheKey('price.%s.%s', [$source, $target]);
    }

    public function prices(string $currency): string
    {
        return $this->cacheKey('prices.%s', [$currency]);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('crypto_compare');
    }
}
