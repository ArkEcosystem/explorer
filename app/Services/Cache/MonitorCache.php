<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\Facades\Network;
use App\ViewModels\WalletViewModel;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class MonitorCache implements Contract
{
    use Concerns\ManagesCache;

    public function getBlockCount(): string
    {
        return $this->get('getBlockCount');
    }

    public function setBlockCount(\Closure $callback): string
    {
        return $this->remember('getBlockCount', Network::blockTime(), $callback);
    }

    public function getTransactions(): int
    {
        return (int) $this->get('getTransactions');
    }

    public function setTransactions(\Closure $callback): int
    {
        return $this->remember('getTransactions', Network::blockTime(), $callback);
    }

    public function getCurrentDelegate(): WalletViewModel
    {
        return $this->get('getCurrentDelegate');
    }

    public function setCurrentDelegate(\Closure $callback): WalletViewModel
    {
        return $this->remember('getCurrentDelegate', Network::blockTime(), $callback);
    }

    public function getNextDelegate(): WalletViewModel
    {
        return $this->get('getNextDelegate');
    }

    public function setNextDelegate(\Closure $callback): WalletViewModel
    {
        return $this->remember('getNextDelegate', Network::blockTime(), $callback);
    }

    public function getCache(): TaggedCache
    {
        return Cache::tags('monitor');
    }
}
