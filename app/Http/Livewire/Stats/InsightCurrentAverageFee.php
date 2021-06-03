<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Enums\TransactionTypeGroupEnum;
use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailableTransactionType;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use App\Services\Transactions\TransactionTypeIcon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

final class InsightCurrentAverageFee extends Component
{
    use AvailableTransactionType;

    public int $transactionType;

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
                'type' => $this->getTransactionTypeLabel($this->transactionType)
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

    private function currentAverageFee(int $transactionType): string
    {
        $value = $this->getFeesAggregatesPerPeriod($transactionType);

        return NumberFormatter::currency(data_get($value, 'average', 0), Network::currency());
    }

    private function minFee(int $transactionType): string
    {
        $value = $this->getFeesAggregatesPerPeriod($transactionType);

        return NumberFormatter::currency(data_get($value, 'minimum', 0), Network::currency());
    }

    private function maxFee(int $transactionType): string
    {
        $value = $this->getFeesAggregatesPerPeriod($transactionType);

        return NumberFormatter::currency(data_get($value, 'maximum', 0), Network::currency());
    }

    private function getFeesAggregatesPerPeriod(int $transactionType): Model | null
    {
        $cacheKey = collect([__CLASS__, 'fee-aggregates-per-transaction-type', $transactionType])->filter()->join('.');

        return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => Transaction::query()
            ->select(DB::raw("AVG(fee / 1e8) as average, MIN(fee / 1e8) as minimum, MAX(fee / 1e8) as maximum"))
            ->where('type_group', TransactionTypeGroupEnum::CORE)
            ->where('type', $transactionType)
            ->first()
        );
    }
}
