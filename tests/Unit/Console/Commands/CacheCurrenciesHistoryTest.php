<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Bus;
use App\Jobs\CacheCurrenciesHistory as CacheCurrenciesHistoryJob;

it('should execute the command', function () {
    Bus::fake();

    Config::set('currencies', [
        'usd' => [
            'currency' => 'USD',
            'locale'   => 'en_US',
        ],
    ]);

    Config::set('explorer.networks.development.canBeExchanged', true);

    $this->artisan('explorer:cache-currencies-history');

    Bus::assertDispatched(CacheCurrenciesHistoryJob::class, fn($job) => $job->source === 'DARK' && $job->currency === 'USD');
});
