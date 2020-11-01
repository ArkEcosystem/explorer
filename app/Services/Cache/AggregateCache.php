<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
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

    public function setFeesByRange(Carbon $start, Carbon $end, Collection $value): void
    {
        $this->put($this->cacheKey('fees_by_range.%s.%s', [$start->unix(), $end->unix()]), $value);
    }

    public function getVolume(): string
    {
        return $this->get('volume');
    }

    public function setVolume(string $value): void
    {
        $this->put('volume', $value);
    }

    public function getTransactionsCount(): string
    {
        return $this->get('transactions_count');
    }

    public function setTransactionsCount(string $value): void
    {
        $this->put('transactions_count', $value);
    }

    public function getVotesCount(): string
    {
        return $this->get('votes_count');
    }

    public function setVotesCount(string $value): void
    {
        $this->put('votes_count', $value);
    }

    public function getVotesPercentage(): string
    {
        return $this->get('votes_percentage');
    }

    public function setVotesPercentage(string $value): void
    {
        $this->put('votes_percentage', $value);
    }

    public function getVotes(): string
    {
        return $this->get('votes');
    }

    public function setVotes(string $value): void
    {
        $this->put('votes', $value);
    }

    public function getDelegateRegistrationCount(): string
    {
        return $this->get('delegate_registration_count');
    }

    public function setDelegateRegistrationCount(string $value): void
    {
        $this->put('delegate_registration_count', $value);
    }

    public function getFeesCollected(): string
    {
        return $this->get('fees_collected');
    }

    public function setFeesCollected(string $value): void
    {
        $this->put('fees_collected');
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('aggregate');
    }
}
