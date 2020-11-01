<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Contracts\Cache as Contract;
use App\DTO\Slot;
use App\Facades\Network;
use App\Models\Block;
use App\Services\Monitor\Monitor;
use App\ViewModels\WalletViewModel;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class MonitorCache implements Contract
{
    use Concerns\ManagesCache;

    public function getCache(): TaggedCache
    {
        return Cache::tags('monitor');
    }

    public function getBlockCount(array $delegates): string
    {
        return $this->getCache()->remember('getBlockCount', Network::blockTime(), function () use ($delegates): string {
            return trans('pages.monitor.statistics.blocks_generated', [
                collect($delegates)->filter(fn ($slot) => $slot->status() === 'done')->count(),
                Network::delegateCount(),
            ]);
        });
    }

    public function getTransactions(): int
    {
        return (int) $this->getCache()->remember('getTransactions', Network::blockTime(), function (): int {
            return (int) Block::whereBetween('height', Monitor::heightRangeByRound(Monitor::roundNumber()))->sum('number_of_transactions');
        });
    }

    public function getCurrentDelegate(array $delegates): WalletViewModel
    {
        return $this->getCache()->remember('getCurrentDelegate', Network::blockTime(), function () use ($delegates): WalletViewModel {
            return $this->getSlotsByStatus($delegates, 'next')->wallet();
        });
    }

    public function getNextDelegate(array $delegates): WalletViewModel
    {
        return $this->getCache()->remember('getNextDelegate', Network::blockTime(), function () use ($delegates): WalletViewModel {
            return $this->getSlotsByStatus($delegates, 'pending')->wallet();
        });
    }

    private function getSlotsByStatus(array $slots, string $status): Slot
    {
        return collect($slots)
            ->filter(fn ($slot) => $slot->status() === $status)
            ->first();
    }
}
