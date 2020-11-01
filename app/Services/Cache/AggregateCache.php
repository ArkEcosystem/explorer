<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Aggregates\TransactionCountAggregate;
use App\Aggregates\TransactionVolumeAggregate;
use App\Aggregates\VoteCountAggregate;
use App\Aggregates\VotePercentageAggregate;
use App\Contracts\Cache as Contract;
use Carbon\Carbon;
use Closure;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class AggregateCache implements Contract
{
    use Concerns\ManagesCache;

    public function feesByRange(Carbon $start, Carbon $end, ?Closure $callback): string
    {
        return $this->remember('fees_by_range.%s.%s', [$start->unix(), $end->unix()], $callback);
    }

    public function volume(): string
    {
        return $this->remember('volume', fn () => (new TransactionVolumeAggregate())->aggregate());
    }

    public function transactionsCount(): string
    {
        return $this->remember('transactions_count', fn () => (new TransactionCountAggregate())->aggregate());
    }

    public function votesCount(): string
    {
        return $this->remember('votes_count', fn () => (new VoteCountAggregate())->aggregate());
    }

    public function votesPercentage(): string
    {
        return $this->remember('votes_percentage', fn () => (new VotePercentageAggregate())->aggregate());
    }

    public function votes(?Closure $callback): string
    {
        return $this->remember('votes', $callback);
    }

    public function delegateRegistrationCount(?Closure $callback): string
    {
        return $this->remember('delegate_registration_count', $callback);
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
