<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Livewire\Livewire;
use Tests\AvailablePeriodsLivewireTest;

beforeEach(fn () => Carbon::setTestNow('2020-06-15 00:00:00'));

it('should return the date from period', function ($period, $from, $fromEpoch) {
    Livewire::test(AvailablePeriodsLivewireTest::class)
        ->set('period', $period)
        ->assertSee($period)
        ->assertSee($from)
        ->assertSee($fromEpoch);
})->with([
    ['day', '2020-06-14', '1973-03-26'],
    ['week', '2020-06-08', '1973-03-20'],
    ['month', '2020-05-15', '1973-02-27'],
    ['quarter', '2020-03-15', '1972-12-27'],
    ['year', '2019-06-15', '1972-03-27'],
    ['all', '1920-06-15', '1873-03-27'],
]);
