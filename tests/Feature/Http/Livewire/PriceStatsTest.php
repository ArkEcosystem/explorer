<?php

declare(strict_types=1);

use App\Http\Livewire\PriceStats;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

it('should render the change and the maxValue for the chart', function () {
    Http::fake([
        'cryptocompare.com/*' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/histohour.json')), true)),
    ]);

    Livewire::test(PriceStats::class)
        ->assertSee('13.70%')
        ->assertSee('maxValue: 2.469');
});

it('should render the changes and the maxValue for the chart', function () {
    Http::fake([
        'cryptocompare.com/*' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/histohour.json')), true)),
    ]);

    Livewire::test(PriceStats::class, ['placeholder' => true])
        ->assertSee('values: [4,5,2,2,2,3,5,1,4,5,6,5,3,3,4,5,6,4,4,4,5,8,8,10],')
        ->assertSee('maxValue: 10');
});
