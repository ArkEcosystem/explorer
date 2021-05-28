<?php

declare(strict_types=1);

use App\Http\Livewire\Stats\InsightAllTimeTransactions;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should render the component', function () {
    Transaction::factory(30)->create(['timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->sub('2 years')->timestamp]);
    Transaction::factory(30)->create(['timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->timestamp]);

    Livewire::test(InsightAllTimeTransactions::class)
        ->set('period', 'day')
        ->assertSee(trans('pages.statistics.insights.all-time-transactions'))
        ->assertSee('60')
        ->assertSee(trans('pages.statistics.insights.transactions'))
        ->assertSee('30')
        ->assertSee('[30]');
});

it('it should filter by year', function () {
    Transaction::factory(30)->create(['timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->sub('2 years')->timestamp]);
    Transaction::factory(40)->create(['timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->sub('11 months')->timestamp]);
    Transaction::factory(50)->create(['timestamp' => Carbon::createFromTimestamp((int) Carbon::now()->timestamp - 1490101200)->timestamp]);

    Livewire::test(InsightAllTimeTransactions::class)
        ->set('period', 'year')
        ->assertSee(trans('pages.statistics.insights.all-time-transactions'))
        ->assertSee('120')
        ->assertSee(trans('pages.statistics.insights.transactions'))
        ->assertSee('90')
        ->assertSee('[50,40]');
});
