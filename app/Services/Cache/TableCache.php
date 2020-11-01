<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class TableCache implements Contract
{
    use Concerns\ManagesCache;

    public function latestBlocks(string $type): string
    {
        return $this->cacheKey('blocks.%s', [$type]);
    }

    public function latestTransactions(string $type): string
    {
        return $this->cacheKey('transactions.%s', [$type]);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('table');
    }
}
