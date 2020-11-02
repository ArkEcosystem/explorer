<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Facades\Network;
use Carbon\Carbon;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class NetworkCache implements Contract
{
    use Concerns\ManagesCache;

    public function getHeight(): int
    {
        return (int) $this->get('height');
    }

    public function setHeight(\Closure $callback): int
    {
        return (int) $this->remember('height', Network::blockTime(), $callback);
    }

    public function getSupply(): string
    {
        return $this->get('supply');
    }

    public function setSupply(\Closure $callback): string
    {
        return $this->remember('supply', Network::blockTime(), $callback);
    }

    public function getVolume(): string
    {
        return $this->get('volume');
    }

    public function setVolume(\Closure $callback): string
    {
        return $this->remember('volume', now()->addMinute(), $callback);
    }

    public function getTransactionsCount(): string
    {
        return $this->get('transactions_count');
    }

    public function setTransactionsCount(\Closure $callback): string
    {
        return $this->remember('transactions_count', now()->addMinute(), $callback);
    }

    public function getVotesCount(): string
    {
        return $this->get('votes_count');
    }

    public function setVotesCount(\Closure $callback): string
    {
        return $this->remember('votes_count', now()->addMinute(), $callback);
    }

    public function getVotesPercentage(): string
    {
        return $this->get('votes_percentage');
    }

    public function setVotesPercentage(\Closure $callback): string
    {
        return $this->remember('votes_percentage', now()->addMinute(), $callback);
    }

    public function getDelegateRegistrationCount(): int
    {
        return (int) $this->get('delegate_registration_count');
    }

    public function setDelegateRegistrationCount(\Closure $callback): int
    {
        return (int) $this->remember('delegate_registration_count', Network::blockTime(), $callback);
    }

    public function getFeesCollected(): string
    {
        return $this->get('fees_collected');
    }

    public function setFeesCollected(\Closure $callback): string
    {
        return $this->remember('fees_collected', Network::blockTime(), $callback);
    }

    public function getFeesByRange(Carbon $start, Carbon $end): Collection
    {
        return $this->get(sprintf('fees_by_range.%s.%s', [$start->unix(), $end->unix()]));
    }

    public function setFeesByRange(Carbon $start, Carbon $end, \Closure $closure): Collection
    {
        return $this->get(sprintf('fees_by_range.%s.%s', [$start->unix(), $end->unix()]), $closure);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('network');
    }
}
