<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use Carbon\Carbon;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class AggregateCache implements Contract
{
    use Concerns\ManagesCache;

    public function feesByRange(Carbon $start, Carbon $end): string
    {
        return $this->cacheKey('fees_by_range.%s.%s', [$start->unix(), $end->unix()]);
    }

    public function volume(): string
    {
        return $this->cacheKey('volume');
    }

    public function transactionsCount(): string
    {
        return $this->cacheKey('transactions_count');
    }

    public function votes(): string
    {
        return $this->cacheKey('votes');
    }

    public function votesCount(): string
    {
        return $this->cacheKey('votes_count');
    }

    public function votesPercentage(): string
    {
        return $this->cacheKey('votes_percentage');
    }

    public function delegateRegistrationCount(): string
    {
        return $this->cacheKey('delegate_registration_count');
    }

    public function feesCollected(): string
    {
        return $this->cacheKey('fees_collected');
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('aggregate');
    }
}
