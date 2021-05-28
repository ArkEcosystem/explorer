<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

trait AvailablePeriods
{
    private function availablePeriods(): array
    {
        return [
            'day' => trans('forms.statistics.day'),
            'week' => trans('forms.statistics.week'),
            'month' => trans('forms.statistics.month'),
            'year' => trans('forms.statistics.year'),
            'all-time' => trans('forms.statistics.all-time'),
        ];
    }
}
