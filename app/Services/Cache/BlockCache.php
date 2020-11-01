<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class BlockCache
{
    use Concerns\ManagesCache;

    public function byId(string $id): string
    {
        return $this->cacheKey('id.%s', [$id]);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('block');
    }
}
