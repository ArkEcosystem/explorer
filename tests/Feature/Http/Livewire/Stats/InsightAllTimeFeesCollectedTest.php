<?php

declare(strict_types=1);

use App\Http\Livewire\Stats\InsightAllTimeFeesCollected;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should render the component', function () {
    Transaction::factory(30)->create(['fee' => 12345678910, 'timestamp' => Carbon::parse('1 year ago')->timestamp]);
    Transaction::factory(30)->create(['fee' => 9234567890, 'timestamp' => Carbon::now()->timestamp]);

    Livewire::test(InsightAllTimeFeesCollected::class)
        ->assertSee(trans('pages.statistics.insights.all-time-fees-collected'))
        ->assertSee('6,474.07404 DARK')
        ->assertSee(trans('pages.statistics.insights.fees'))
        ->assertSee('2,770.370367 DARK')
        ->assertSee('["2770.3703670000000000"]');
});

it('should filter by year', function () {
    Transaction::factory(30)->create(['fee' => 12345678910, 'timestamp' => Carbon::parse('11 months ago')->timestamp]);
    Transaction::factory(30)->create(['fee' => 9234567890, 'timestamp' => Carbon::now()->timestamp]);
    Transaction::factory(30)->create(['fee' => 5234967810]);

    Livewire::test(InsightAllTimeFeesCollected::class)
        ->set('period', 'year')
        ->assertSee(trans('pages.statistics.insights.all-time-fees-collected'))
        ->assertSee('8,044.564383 DARK')
        ->assertSee(trans('pages.statistics.insights.fees'))
        ->assertSee('6,474.07404 DARK')
        ->assertSee('["2770.3703670000000000","3703.7036730000000000"]');
});
