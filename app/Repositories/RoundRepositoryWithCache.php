<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\RoundRepository;
use App\Models\Round;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class RoundRepositoryWithCache implements RoundRepository
{
    private RoundRepository $rounds;

    public function __construct(RoundRepository $rounds)
    {
        $this->rounds = $rounds;
    }

    public function allByRound(int $round): Collection
    {
        return Cache::remember(
            "repository:allByRound.{$round}",
            60,
            fn () => $this->rounds->allByRound($round)
        );
    }

    public function currentRound(): Round
    {
        return Cache::remember(
            'repository:currentRound',
            60,
            fn () => $this->rounds->currentRound()
        );
    }
}
