<?php

declare(strict_types=1);

namespace App\Facades;

use App\Contracts\RoundRepository;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder allByRound(int $round)
 * @method static int current()
 */
final class Rounds extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return RoundRepository::class;
    }
}
