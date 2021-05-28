<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

final class InsightAllTimeTransactions extends Component
{
    use AvailablePeriods;

    public string $period = 'week';

    private string $chartColor = 'grey';

    private string $refreshInterval = '';

    public function mount(): void
    {
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
    }

    public function render(): View
    {
        return view('livewire.stats.insight-all-time-transactions', [
            'allTimeTransactionsTitle' => trans('pages.statistics.insights.all-time-transactions'),
            'allTimeTransactionsValue' => $this->allTimeTransactions(),
            'transactionsTitle'        => trans('pages.statistics.insights.transactions'),
            'transactionsValue'        => $this->countTransactionsPerPeriod($this->period),
            'chartValues'              => $this->chartValues($this->period),
            'chartColor'               => $this->chartColor,
            'options'                  => $this->availablePeriods(),
            'refreshInterval'          => $this->refreshInterval,
        ]);
    }

    private function allTimeTransactions(): string
    {
        $value = $this->transactionsPerPeriod('all-time');

        return NumberFormatter::number($value);
    }

    private function countTransactionsPerPeriod(string $period): string
    {
        $value = $this->transactionsPerPeriod($period)->pluck('transactions')->sum();

        return NumberFormatter::number($value);
    }

    private function chartValues(string $period): Collection
    {
        $value = $this->transactionsPerPeriod($period)->pluck('transactions');

        return collect($value);
    }

    private function transactionsPerPeriod(string $period): EloquentCollection | string
    {
        $cacheKey = __CLASS__.".transactions-per-period.{$period}";

        if ($period === 'all-time') {
            return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => (string) Transaction::count());
        }

        [$from, $to] = $this->getRangeFromPeriod($period);
        $cacheKey .= ".{$from }.{$to}";

        return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => Transaction::query()
                ->select(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') as period, COUNT('id') as transactions"))
                ->where('timestamp', '>', $from)
                ->where('timestamp', '<=', $to)
                ->latest('period')
                ->groupBy('period')
                ->get()
        );
    }
}
