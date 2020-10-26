<?php

declare(strict_types=1);

use App\Http\Livewire\MonitorStatistics;
use Livewire\Livewire;

it('should update the currency', function () {
    Livewire::test(MonitorStatistics::class)
        ->assertSee(trans('pages.monitor.statistics.delegate_registrations'))
        ->assertSee(trans('pages.monitor.statistics.block_reward'))
        ->assertSee(trans('pages.monitor.statistics.fees_collected'))
        ->assertSee(trans('pages.monitor.statistics.votes'));
});
