<?php

declare(strict_types=1);

use App\Http\Livewire\Stats\InsightAllTimeFeesCollected;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(function (): void {
    configureExplorerDatabase();

    Carbon::setTestNow('2021-01-01 00:00:00');
});

it('should render the component', function () {
    Transaction::factory(30)->create(['fee' => 12345678910, 'timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->sub('2 years')->timestamp]);
    Transaction::factory(30)->create(['fee' => 9234567890, 'timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->timestamp]);

    Livewire::test(InsightAllTimeFeesCollected::class)
        ->set('period', 'day')
        ->assertSee(trans('pages.statistics.insights.all-time-fees-collected'))
        ->assertSee('6,474.07404 DARK')
        ->assertSee(trans('pages.statistics.insights.fees'))
        ->assertSee('2,770.370367 DARK')
        ->assertSee('["2770.3703670000000000"]');
});

it('should filter by year', function () {
    Transaction::factory(30)->create(['fee' => 234678910, 'timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->sub('2 years')->timestamp]);
    Transaction::factory(30)->create(['fee' => 12345678910, 'timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->sub('11 months')->timestamp]);
    Transaction::factory(30)->create(['fee' => 9234567890, 'timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->timestamp]);

    Livewire::test(InsightAllTimeFeesCollected::class)
        ->set('period', 'year')
        ->assertSee(trans('pages.statistics.insights.all-time-fees-collected'))
        ->assertSee('6,544.477713 DARK')
        ->assertSee(trans('pages.statistics.insights.fees'))
        ->assertSee('6,474.07404 DARK')
        ->assertSee('["2770.3703670000000000","3703.7036730000000000"]');
});
