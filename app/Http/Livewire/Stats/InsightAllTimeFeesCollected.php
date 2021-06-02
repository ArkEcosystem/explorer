<?php

declare(strict_types=1);

namespace App\Http\Livewire\Stats;

use App\Facades\Network;
use App\Http\Livewire\Concerns\AvailablePeriods;
use App\Models\Transaction;
use App\Services\NumberFormatter;
use App\Services\Settings;
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
        $this->period          = $this->defaultPeriod();
    }

    public function render(): View
    {
        return view('livewire.stats.insight-all-time-fees-collected', [
            'allTimeFeesCollectedTitle' => trans('pages.statistics.insights.all-time-fees-collected'),
            'allTimeFeesCollectedValue' => $this->allTimeFeesCollected(),
            'feesTitle'                 => trans('pages.statistics.insights.fees'),
            'feesValue'                 => $this->fees($this->period),
            'chartValues'               => $this->chartValues($this->period),
            'chartTheme'                => $this->chartTheme(),
            'options'                   => $this->availablePeriods(),
            'refreshInterval'           => $this->refreshInterval,
        ]);
    }

    private function allTimeFeesCollected(): string
    {
        $value = $this->transactionsPerPeriod('all-time');

        return NumberFormatter::currency((string) $value, Network::currency());
    }

    private function fees(string $period): string
    {
        /** @var Transaction $value */
        $value = $this->transactionsPerPeriod($period);

        return NumberFormatter::currency($value->pluck('fees')->sum(), Network::currency());
    }

    private function chartValues(string $period): Collection
    {
        /** @var Transaction $value */
        $value = $this->transactionsPerPeriod($period);

        return collect($value->pluck('fees'));
    }

    private function chartTheme(): Collection
    {
        $mode = Settings::usesDarkTheme() ? 'dark' : 'light';

        return collect(['name' => 'yellow', 'mode' => $mode]);
    }

    private function transactionsPerPeriod(string $period): EloquentCollection | string
    {
        $cacheKey = __CLASS__.".transactions-per-period.{$period}";

//        if ($period === 'all-time') {
//            return Cache::remember($cacheKey, (int) $this->refreshInterval, function (): float {
//                $value = Transaction::select(DB::raw('sum(fee / 1e8) as fees'))->first();
//
//                return (float) data_get($value, 'fees', '0');
//            });
//        }

        $from = $this->getRangeFromPeriod($period);
        $cacheKey .= ".{$from }";

        return Cache::remember($cacheKey, (int) $this->refreshInterval, fn () => Transaction::query()
                ->select(DB::raw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') as period, SUM(fee /1e8) as fees"))
//                ->when($period !== 'all-time', function ($query) use ($from): void {
                ->whereRaw("to_char(to_timestamp(timestamp), 'yyyy-mm-dd') > ?", [$from])
//                })
                ->latest('period')
                ->groupBy('period')
                ->get()
        );
    }
}
