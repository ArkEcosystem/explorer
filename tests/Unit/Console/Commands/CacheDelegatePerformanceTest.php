<?php

declare(strict_types=1);

use App\Console\Commands\CacheDelegatePerformance;
use App\Facades\Network;
use App\Models\Block;
use App\Models\Round;
use App\Services\Cache\WalletCache;
use Illuminate\Support\Facades\Cache;

it('should cache the past performance for a public key', function () {
    $publicKey = 'generator';

    Round::factory()->create([
        'round'      => '16',
        'public_key' => $publicKey,
    ]);

    foreach (range(10, 14) as $round) {
        Block::factory()->create([
            'generator_public_key' => $publicKey,
            'height'               => $round * Network::delegateCount(),
        ]);
    }

    expect(Block::whereGeneratorPublicKey($publicKey)->count())->toBe(5);
    expect(Cache::tags('wallet')->has(md5("performance/$publicKey")))->toBeFalse();

    (new CacheDelegatePerformance())->handle();

    expect(Cache::tags('wallet')->has(md5("performance/$publicKey")))->toBeTrue();
    expect((new WalletCache())->getPerformance($publicKey))->toBe([
        true,
        true,
        true,
        true,
        true,
    ]);
});

it('should cache end of a round missed blocks for a public key ', function () {
    $publicKey = 'generator';

    Round::factory()->create([
        'round'      => '16',
        'public_key' => $publicKey,
    ]);

    foreach (range(10, 13) as $round) {
        Block::factory()->create([
            'generator_public_key' => $publicKey,
            'height'               => $round * Network::delegateCount(),
        ]);
    }

    expect(Block::whereGeneratorPublicKey($publicKey)->count())->toBe(4);
    expect(Cache::tags('wallet')->has(md5("performance/$publicKey")))->toBeFalse();

    (new CacheDelegatePerformance())->handle();

    expect(Cache::tags('wallet')->has(md5("performance/$publicKey")))->toBeTrue();
    expect((new WalletCache())->getPerformance($publicKey))->toBe([
        true,
        true,
        true,
        true,
        false,
    ]);
});
