<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Facades\Network;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class NetworkCache implements Contract
{
    use Concerns\ManagesCache;

    public function height(): string
    {
        return $this->cacheKey('height.%s', [Network::name()]);
    }

    public function supply(): string
    {
        return $this->cacheKey('supply.%s', [Network::name()]);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('network');
    }
}
