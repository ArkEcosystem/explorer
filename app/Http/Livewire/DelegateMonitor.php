<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\DTO\Slot;
use App\Facades\Network;
use App\Facades\Rounds;
use App\Models\Block;
use App\Services\Cache\MonitorCache;
use App\Services\Cache\WalletCache;
use App\Services\Monitor\DelegateTracker;
use App\Services\Monitor\Monitor;
use App\ViewModels\ViewModelFactory;
use App\ViewModels\WalletViewModel;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

final class DelegateMonitor extends Component
{
    private array $delegates = [];

    private array $statistics = [];

    public function render(): View
    {
        return view('livewire.delegate-monitor', [
            'delegates'  => $this->delegates,
            'statistics' => $this->statistics,
        ]);
    }

    public function pollDelegates(): void
    {
        // $tracking = DelegateTracker::execute(Monitor::roundDelegates(112168));

        $roundNumber = Rounds::currentRound()->round;
        $heightRange = Monitor::heightRangeByRound($roundNumber);
        $tracking    = DelegateTracker::execute(Rounds::allByRound($roundNumber));
        $roundBlocks = $this->getBlocksByRange(Arr::pluck($tracking, 'publicKey'), $heightRange);

        $delegates = [];

        for ($i = 0; $i < count($tracking); $i++) {
            $delegate = array_values($tracking)[$i];

            $delegates[] = new Slot([
                'publicKey'  => $delegate['publicKey'],
                'order'      => $i + 1,
                'wallet'     => ViewModelFactory::make((new WalletCache())->getDelegate($delegate['publicKey'])),
                // @TODO: instead of now we need to use the time at which the round starts
                'forging_at' => Carbon::now()->addMilliseconds($delegate['time']),
                'last_block' => (new WalletCache())->getLastBlock($delegate['publicKey']),
                'status'     => $delegate['status'],
            ], $roundBlocks);
        }

        $this->delegates = $delegates;

        $this->statistics = [
            'blockCount'      => $this->getBlockCount(),
            'transactions'    => $this->getTransactions(),
            'currentDelegate' => $this->getCurrentDelegate(),
            'nextDelegate'    => $this->getNextDelegate(),
        ];
    }

    private function getBlockCount(): string
    {
        return (new MonitorCache())->setBlockCount(function (): string {
            return trans('pages.delegates.statistics.blocks_generated', [
                collect($this->delegates)->filter(fn ($slot) => $slot->status() === 'done')->count(),
                Network::delegateCount(),
            ]);
        });
    }

    private function getTransactions(): int
    {
        return (new MonitorCache())->setTransactions(function (): int {
            return (int) Block::whereBetween('height', Monitor::heightRangeByRound(Monitor::roundNumber()))->sum('number_of_transactions');
        });
    }

    private function getCurrentDelegate(): WalletViewModel
    {
        return (new MonitorCache())->setCurrentDelegate(function (): WalletViewModel {
            return $this->getSlotsByStatus($this->delegates, 'next')->wallet();
        });
    }

    private function getNextDelegate(): WalletViewModel
    {
        return (new MonitorCache())->setNextDelegate(function (): WalletViewModel {
            return $this->getSlotsByStatus($this->delegates, 'pending')->wallet();
        });
    }

    private function getBlocksByRange(array $publicKeys, array $heightRange): Collection
    {
        return Block::query()
            ->whereIn('generator_public_key', $publicKeys)
            ->whereBetween('height', $heightRange)
            ->get();
    }

    private function getSlotsByStatus(array $slots, string $status): Slot
    {
        return collect($slots)
            ->filter(fn ($slot) => $slot->status() === $status)
            ->first();
    }
}
