<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Http\Livewire\Concerns\AvailableTransactionType;
use App\Http\Livewire\Concerns\StatisticsChart;
use App\Models\Scopes\VoteScope;
use App\Models\Transaction;
use App\Services\BigNumber;
use App\Services\Cache\FeeCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

final class InsightCurrentAverageFee extends Component
{
    use AvailableTransactionType;
    use StatisticsChart;

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
        $fee = $this->getFeesAggregatesPerType($transactionType);

        return $this->asMoney($fee->get('avg', 0));
    }

    private function minFee(string $transactionType): string
    {
        $fee = $this->getFeesAggregatesPerType($transactionType);

        return $this->asMoney($fee->get('min', 0));
    }

    private function maxFee(string $transactionType): string
    {
        $fee = $this->getFeesAggregatesPerType($transactionType);

        return $this->asMoney($fee->get('max', 0));
    }

    private function getFeesAggregatesPerType(string $transactionType): Collection
    {
        $fee = (new FeeCache());

        return collect([
            'avg' => $fee->getAverage($transactionType),
            'min' => $fee->getMinimum($transactionType),
            'max' => $fee->getMaximum($transactionType),
        ]);
    }
}
