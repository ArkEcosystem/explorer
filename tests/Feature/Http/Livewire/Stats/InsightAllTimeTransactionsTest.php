<?php

declare(strict_types=1);

use App\Http\Livewire\Stats\InsightAllTimeTransactions;
use App\Models\Transaction;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should render the component', function () {
    Livewire::test(InsightAllTimeTransactions::class)
        ->set('period', 'day')
        ->assertSee(trans('pages.statistics.insights.all-time-transactions'))
        ->assertSee('0 DARK')
        ->assertSee(trans('pages.statistics.insights.fees'))
        ->assertSee('2,770.370367 DARK')
        ->assertSee('["2770.3703670000000000"]');
});
