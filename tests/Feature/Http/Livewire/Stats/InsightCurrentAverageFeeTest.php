<?php

declare(strict_types=1);

use App\Enums\StatsTransactionTypes;
use App\Http\Livewire\Stats\InsightCurrentAverageFee;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

beforeEach(function () {
    Config::set('explorer.network', 'development');

    Http::fake([
        'dwallets.ark.io/api/node/fees*' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/fees.json')), true), 200),
    ]);

    Artisan::call('explorer:cache-node-fees');
});

it('should render the component', function () {
    Livewire::test(InsightCurrentAverageFee::class)
        ->assertSee(trans('pages.statistics.insights.current-average-fee', ['type' => 'All']))
        ->assertSee('9.31 DARK')
        ->assertSee(trans('pages.statistics.insights.min-fee'))
        ->assertSee('0 DARK')
        ->assertSee(trans('pages.statistics.insights.max-fee'))
        ->assertSee('50 DARK');
});

it('should filter by transfer', function () {
    Livewire::test(InsightCurrentAverageFee::class)
        ->set('transactionType', StatsTransactionTypes::TRANSFER)
        ->assertSee(trans('pages.statistics.insights.current-average-fee', ['type' => 'Transfer']))
        ->assertSee('0.07 DARK')
        ->assertSee(trans('pages.statistics.insights.min-fee'))
        ->assertSee('0.01 DARK')
        ->assertSee(trans('pages.statistics.insights.max-fee'))
        ->assertSee('0.1 DARK');
});
