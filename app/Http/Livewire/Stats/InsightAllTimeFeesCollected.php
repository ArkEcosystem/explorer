<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

final class InsightAllTimeFeesCollected extends Component
{
    use AvailablePeriods;

    public string $period = 'week';

    private string $chartColor = 'yellow';

    private string $refreshInterval = '';

    public function mount(): void
    {
        $this->refreshInterval = (string) config('explorer.statistics.refreshInterval', '60');
    }

    public function render(): View
    {
        return view('livewire.stats.insight-all-time-fees-collected', [
            'allTimeFeesCollectedTitle' => trans('pages.statistics.insights.all-time-fees-collected'),
            'allTimeFeesCollectedValue' => $this->allTimeFeesCollected(),
            'feesTitle'                 => trans('pages.statistics.insights.fees'),
            'feesValue'                 => $this->fees($this->period),
            'chartValues'               => $this->chartValues($this->period),
            'chartColor'                => $this->chartColor,
            'options'                   => $this->availablePeriods(),
            'refreshInterval'           => $this->refreshInterval,
        ]);
    }

    private function allTimeFeesCollected(): string
    {
        $value = $this->transactionsPerPeriod('all-time');

        return NumberFormatter::currency($value, Network::currency());
    }

    private function fees(string $period): string
    {
        $value = $this->transactionsPerPeriod($period)->pluck('fee')->sum();

        return NumberFormatter::currency($value, Network::currency());
    }

    private function chartValues(string $period): Collection
    {
        $value = $this->transactionsPerPeriod($period)->pluck('fee');

        return collect($value);
    }

    private function transactionsPerPeriod(string $period): EloquentCollection | string
    {
        $cacheKey = __CLASS__.".transactions-per-period.{$period}";

        if ($period === 'all-time') {
            return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => (string) Transaction::select(DB::raw('sum(fee / 1e8) as fee'))->first()->fee);
        }

        [$from, $to] = $this->getRangeFromPeriod($period);
        $cacheKey .= ".{$from }.{$to}";

        return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => Transaction::query()
                ->select(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') as period, SUM(fee / 1e8) as fee"))
                ->when($period !== 'all-time', function ($query) use ($from, $to): void {
                    $query
                        ->where(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd')"), '>', $from)
                        ->where(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd')"), '<=', $to);
                })
                ->latest('period')
                ->groupBy('period')
                ->get()
        );
    }
}
