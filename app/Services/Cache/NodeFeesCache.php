<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Services\Cache\Concerns\ManagesCache;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class NodeFeesCache implements Contract
{
    use ManagesCache;

    public function getAggregates(): Collection
    {
        return $this->get(sprintf('aggregates'), collect([]));
    }

    public function setAggregates(Collection $data): void
    {
        $this->put(sprintf('aggregates'), $data);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('node-fees');
    }
}
