<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait AvailablePeriods
{
    private function availablePeriods(): array
    {
        return [
            'day'   => trans('forms.statistics.day'),
            'week'  => trans('forms.statistics.week'),
            'month' => trans('forms.statistics.month'),
            'year'  => trans('forms.statistics.year'),
        ];
    }

    private function getRangeFromPeriod(string $period): array
    {
        if (! collect($this->availablePeriods())->keys()->containsStrict(Str::lower($period))) {
            return [null, null];
        }

        $from = Carbon::now()->sub("1 $period")->toDateString();
        $to = Carbon::now()->toDateString();

        return [$from, $to];
    }
}
