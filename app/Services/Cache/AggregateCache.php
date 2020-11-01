<?php

declare(strict_types=1);

namespace App\Services\Cache;

use Carbon\Carbon;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class AggregateCache
{
    use Concerns\HasCacheKey;

    public static function get(): TaggedCache
    {
        return Cache::tags('aggregate');
    }

    public static function feesByRange(Carbon $start, Carbon $end): string
    {
        return static::cacheKey('fees_by_range.%s.%s', [$start->unix(), $end->unix()]);
    }

    public static function volume(): string
    {
        return static::cacheKey('volume');
    }

    public static function transactionsCount(): string
    {
        return static::cacheKey('transactions_count');
    }

    public static function votes(): string
    {
        return static::cacheKey('votes');
    }

    public static function votesCount(): string
    {
        return static::cacheKey('votes_count');
    }

    public static function votesPercentage(): string
    {
        return static::cacheKey('votes_percentage');
    }

    public static function delegateRegistrationCount(): string
    {
        return static::cacheKey('delegate_registration_count');
    }

    public static function feesCollected(): string
    {
        return static::cacheKey('fees_collected');
    }
}
