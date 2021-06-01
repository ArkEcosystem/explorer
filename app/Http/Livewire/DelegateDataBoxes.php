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
use App\ViewModels\ViewModelFactory;
use App\ViewModels\WalletViewModel;
use Illuminate\View\View;
use Livewire\Component;

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
        $this->statistics = [
            'blockCount'   => $this->getBlockCount(),
            'nextDelegate' => $this->getNextDelegate(),
            'performances' => $this->getDelegatesPerformance(),
        ];
    }

    public function getDelegatesPerformance(): array
    {
        foreach ($this->delegates as $delegate) {
            $this->getDelegatePerformance($delegate->wallet()->model()->public_key);
        }

        $parsedPerformances = array_count_values($this->forgingPerformances);

        return [
            'forging' => $parsedPerformances[DelegateForgingStatus::forging] ?? 0,
            'missed'  => $parsedPerformances[DelegateForgingStatus::missed] ?? 0,
            'missing' => $parsedPerformances[DelegateForgingStatus::missing] ?? 0,
        ];
    }

    public function getDelegatePerformance(string $publicKey): void
    {
        $delegate = ViewModelFactory::make((new WalletCache())->getDelegate($publicKey));

        /** @var WalletViewModel $delegate */
        if ($delegate->hasForged()) {
            $this->forgingPerformances[$publicKey] = DelegateForgingStatus::forging;
        /** @var WalletViewModel $delegate */
        } elseif ($delegate->keepsMissing()) {
            $this->forgingPerformances[$publicKey] = DelegateForgingStatus::missing;
        } else {
            $this->forgingPerformances[$publicKey] = DelegateForgingStatus::missed;
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
