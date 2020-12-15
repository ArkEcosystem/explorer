<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Concerns\ManagesCache;
use App\Contracts\RoundRepository;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class RoundRepositoryWithCache implements RoundRepository
{
    use ManagesCache;

    public function __construct(private RoundRepository $rounds)
    {
    }

    public function allByRound(int $round): Collection
    {
        return $this->remember(fn () => $this->rounds->allByRound($round));
    }

    public function current(): int
    {
        return $this->rounds->current();
    }

    private function getCache(): TaggedCache
    {
        return Cache::tags('rounds');
    }
}
