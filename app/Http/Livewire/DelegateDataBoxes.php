<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\DTO\Slot;
use App\Enums\DelegateForgingStatus;
use App\Facades\Network;
use App\Http\Livewire\Concerns\DelegateData;
use App\Models\Block;
use App\Services\Cache\MonitorCache;
use App\Services\Cache\WalletCache;
use App\Services\Monitor\Monitor;
use App\ViewModels\WalletViewModel;
use Illuminate\View\View;
use Livewire\Component;
use Throwable;

final class DelegateDataBoxes extends Component
{
    use DelegateData;

    private array $delegates = [];

    private array $statistics = [];

    public array $forgingPerformances = [];

    public function render(): View
    {
        $this->delegates = $this->fetchDelegates();

        return view('livewire.delegate-data-boxes', [
            'statistics' => $this->statistics,
        ]);
    }

    public function pollStatistics(): void
    {
        try {
            $this->statistics = [
                'blockCount'      => $this->getBlockCount(),
                'nextDelegate'    => $this->getNextDelegate(),
                'performances'    => $this->getDelegatesPerformance(),
            ];

            // @codeCoverageIgnoreStart
        } catch (Throwable) {
            $this->pollStatistics();
        }
        // @codeCoverageIgnoreEnd
    }

    public function getDelegatesPerformance(): array
    {
        foreach ($this->delegates as $delegate) {
            $this->getDelegatePerformance($delegate->wallet()->model()->public_key);
        }

        $parsedPerformances = array_count_values($this->forgingPerformances);

        return [
            'forging'     => $parsedPerformances[DelegateForgingStatus::forging] ?? 0,
            'missed'      => $parsedPerformances[DelegateForgingStatus::missed] ?? 0,
            'missing'     => $parsedPerformances[DelegateForgingStatus::missing] ?? 0,
        ];
    }

    public function getDelegatePerformance(string $publicKey): void
    {
        $performances = (new WalletCache())->getPerformance($publicKey);

        $lastElement     = array_slice($performances, -1);
        $lastTwoElements = array_slice($performances, -2);

        $uniquePerformances = array_unique($performances);

        if (count($uniquePerformances) === 1 && $uniquePerformances[0] === true || $lastElement[0] === true) {
            $this->forgingPerformances[$publicKey] = DelegateForgingStatus::forging;
            return;
        }

        if (count($uniquePerformances) === 1 && $uniquePerformances[0] === false || count(array_unique($lastTwoElements)) === 1 && array_unique($lastTwoElements)[0] === false) {
            $this->forgingPerformances[$publicKey] = DelegateForgingStatus::missing;
            return;
        }

        if ($lastElement[0] === false) {
            $this->forgingPerformances[$publicKey] = DelegateForgingStatus::missed;
            return;
        }
    }

    public function getBlockCount(): string
    {
        return (new MonitorCache())->setBlockCount(function (): string {
            return trans('pages.delegates.statistics.blocks_generated', [
                Network::delegateCount() - (Monitor::heightRangeByRound(Monitor::roundNumber())[1] - Block::max('height')),
                Network::delegateCount(),
            ]);
        });
    }

    public function getNextDelegate(): WalletViewModel
    {
        $this->delegates = $this->fetchDelegates();

        return (new MonitorCache())->setNextDelegate(function (): WalletViewModel {
            return $this->getSlotsByStatus($this->delegates, 'pending')->wallet();
        });
    }

    private function getSlotsByStatus(array $slots, string $status): Slot
    {
        return collect($slots)
            ->filter(fn ($slot) => $slot->status() === $status)
            ->first();
    }
}
