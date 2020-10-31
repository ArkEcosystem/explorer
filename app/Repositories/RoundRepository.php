<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Round;
use App\Repositories\Concerns\ManagesCache;
use Illuminate\Support\Collection;

final class RoundRepository
{
    use ManagesCache;

    public function allByRound(int $round): Collection
    {
        return Round::query()
            ->where('round', $round)
            ->orderBy('balance', 'desc')
            ->orderBy('public_key', 'asc')
            ->get();
    }

    public function currentRound(): Round
    {
        return Round::orderBy('round', 'desc')->firstOrFail();
    }
}
