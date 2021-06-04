<?php

declare(strict_types=1);

use App\Http\Livewire\Stats\InsightAllTimeFeesCollected;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should render the component', function () {
    Transaction::factory(30)->create(['fee' => 12345678910, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->sub('2 years')->unix()]);
    Transaction::factory(30)->create(['fee' => 9234567890, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->unix()]);

    Artisan::call('explorer:cache-fees');

    Livewire::test(InsightAllTimeFeesCollected::class)
        ->set('period', 'day')
        ->assertSee(trans('pages.statistics.insights.all-time-fees-collected'))
        ->assertSee('6,474.07 DARK')
        ->assertSee(trans('pages.statistics.insights.fees'))
        ->assertSee('2,770.37 DARK')
        ->assertSee('[0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,2770.370367]');
});

it('should filter by year', function () {
    Transaction::factory(30)->create(['fee' => 234678910, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->sub('2 years')->unix()]);
    Transaction::factory(30)->create(['fee' => 12345678910, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->sub('11 months')->unix()]);
    Transaction::factory(30)->create(['fee' => 9234567890, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->unix()]);

    Artisan::call('explorer:cache-fees');

    Livewire::test(InsightAllTimeFeesCollected::class)
        ->set('period', 'year')
        ->assertSee(trans('pages.statistics.insights.all-time-fees-collected'))
        ->assertSee('6,544.48 DARK')
        ->assertSee(trans('pages.statistics.insights.fees'))
        ->assertSee('6,474.07 DARK')
        ->assertSee('[3703.703673,0,0,0,0,0,0,0,0,0,0,2770.370367]');
});
