<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Aggregates\DailyFeeAggregate;
use App\Aggregates\TransactionCountAggregate;
use App\Aggregates\TransactionVolumeAggregate;
use App\Aggregates\VoteCountAggregate;
use App\Aggregates\VotePercentageAggregate;
use App\Contracts\Cache as Contract;
use App\Facades\Network;
use App\Models\Scopes\DelegateRegistrationScope;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class AggregateCache implements Contract
{
    use Concerns\ManagesCache;

    public function getFeesByRange(Carbon $start, Carbon $end): Collection
    {
        return $this->get($this->cacheKey('fees_by_range.%s.%s', [$start->unix(), $end->unix()]));
    }

    public function getVolume(): string
    {
        return $this->remember('volume', 60, fn () => (new TransactionVolumeAggregate())->aggregate());
    }

    public function getTransactionsCount(): string
    {
        return $this->remember('transactions_count', 60, fn () => (new TransactionCountAggregate())->aggregate());
    }

    public function getVotes(): string
    {
        return $this->remember('votes', Network::blockTime(), fn (): string => (new VoteCountAggregate())->aggregate());
    }

    public function getVotesCount(): string
    {
        return $this->remember('votes_count', 60, fn () => (new VoteCountAggregate())->aggregate());
    }

    public function getVotesPercentage(): string
    {
        return $this->remember('votes_percentage', 60, fn () => (new VotePercentageAggregate())->aggregate());
    }

    public function getDelegateRegistrationCount(): int
    {
        return (int) $this->remember('delegate_registration_count', Network::blockTime(), function (): int {
            return Transaction::withScope(DelegateRegistrationScope::class)->count();
        });
    }

    public function getFeesCollected(): string
    {
        return $this->remember('fees_collected', Network::blockTime(), fn (): string => (new DailyFeeAggregate())->aggregate());
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('aggregate');
    }
}
