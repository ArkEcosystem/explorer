<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface RoundRepository
{
    public function allByRound(int $round): Builder;

    public function current(): int;
}
