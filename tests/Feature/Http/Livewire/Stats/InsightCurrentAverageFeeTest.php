<?php

declare(strict_types=1);

use App\Http\Livewire\Stats\InsightCurrentAverageFee;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(function (): void {
    configureExplorerDatabase();

    Carbon::setTestNow('2020-06-15 00:00:00');
});

it('should render the component', function () {
    Transaction::factory(30)->create(['fee' => 12345678910, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->sub('2 years')->unix()]);
    Transaction::factory(10)->create(['fee' => 237890, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->unix()]);
    Transaction::factory(20)->create(['fee' => 915637890, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->unix()]);
    Transaction::factory(30)->create(['fee' => 1234890, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->unix()]);

    Livewire::test(InsightCurrentAverageFee::class)
        ->set('transactionType', 'day')
        ->assertSee(trans('pages.statistics.insights.current-average-fee'))
        ->assertSee('3.06 DARK')
        ->assertSee(trans('pages.statistics.insights.min-fee'))
        ->assertSee('0. DARK')
        ->assertSee(trans('pages.statistics.insights.max-fee'))
        ->assertSee('9.16 DARK');
});

it('should filter by year', function () {
    Transaction::factory()->create(['fee' => 12345678910, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->sub('2 years')->unix()]);
    Transaction::factory()->create(['fee' => 2378922340, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->unix()]);
    Transaction::factory()->create(['fee' => 9156378901, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->unix()]);
    Transaction::factory()->create(['fee' => 1234890918, 'timestamp' => Carbon::createFromTimestamp(Carbon::now()->unix() - 1490101200)->unix()]);

    Livewire::test(InsightCurrentAverageFee::class)
        ->set('transactionType', 'year')
        ->assertSee(trans('pages.statistics.insights.current-average-fee'))
        ->assertSee('42.57 DARK')
        ->assertSee(trans('pages.statistics.insights.min-fee'))
        ->assertSee('12.35 DARK')
        ->assertSee(trans('pages.statistics.insights.max-fee'))
        ->assertSee('91.56 DARK');
});
