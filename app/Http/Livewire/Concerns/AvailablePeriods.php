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

    private function getRangeFromPeriod(string $period): string | null
    {
        if (! collect($this->availablePeriods())->keys()->containsStrict(Str::lower($period))) {
            return null;
        }

        $arkEpoch = 1490101200;
        $epoch = (string) ((int) Carbon::now()->timestamp - $arkEpoch);

        return Carbon::parse($epoch)->sub("1 $period")->toDateString();
    }
}
