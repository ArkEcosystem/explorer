<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailableTransactionType;
use App\Services\Cache\FeeCache;
use App\Services\NumberFormatter;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

    final class InsightCurrentAverageFee extends Component
    {
        use AvailableTransactionType;

        public string $transactionType = '';

        private string $refreshInterval = '';

        public function mount(): void
        {
            $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
            $this->transactionType = $this->defaultTransactionType();
        }

        public function render(): View
        {
            return view('livewire.stats.insight-current-average-fee', [
            'currentAverageFeeTitle' => trans('pages.statistics.insights.current-average-fee', [
                'type' => $this->getTransactionTypeLabel($this->transactionType),
            ]),
            'currentAverageFeeValue' => $this->currentAverageFee($this->transactionType),
            'minFeeTitle'            => trans('pages.statistics.insights.min-fee'),
            'minFeeValue'            => $this->minFee($this->transactionType),
            'maxFeeTitle'            => trans('pages.statistics.insights.max-fee'),
            'maxFeeValue'            => $this->maxFee($this->transactionType),
            'options'                => $this->availableTransactionTypes(),
            'refreshInterval'        => $this->refreshInterval,
        ]);
        }

        private function currentAverageFee(string $transactionType): string
        {
            $value = $this->getFeesAggregatesPerPeriod($transactionType);

            return NumberFormatter::currency(data_get($value, 'avg', 0), Network::currency());
        }

        private function minFee(string $transactionType): string
        {
            $value = $this->getFeesAggregatesPerPeriod($transactionType);

            return NumberFormatter::currency(data_get($value, 'min', 0), Network::currency());
        }

        private function maxFee(string $transactionType): string
        {
            $value = $this->getFeesAggregatesPerPeriod($transactionType);

            return NumberFormatter::currency(data_get($value, 'max', 0), Network::currency());
        }

        private function getFeesAggregatesPerPeriod(string $transactionType): Collection
        {
            $fees = (new FeeCache());

            return collect([
                'avg' => $fees->getAverage($transactionType),
                'min' => $fees->getMinimum($transactionType),
                'max' => $fees->getMaximum($transactionType),
            ]);
        }
    }
