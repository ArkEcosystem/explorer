<?php

declare(strict_types=1);

use App\Console\Commands\CacheDelegatePerformance;
// use App\Jobs\CachePastRoundPerformanceByPublicKey;
use App\Models\Round;
use App\Models\Wallet;
use Illuminate\Support\Facades\Queue;
use App\Facades\Network;
use App\Models\Block;
use App\Services\Cache\WalletCache;
use Illuminate\Support\Facades\Cache;

// it('should execute the command', function () {
//     Queue::fake();

//     Wallet::factory(51)->create()->each(function () {
//         Round::factory()->create(['round' => '112168']);
//     });

//     (new CacheDelegatePerformance())->handle();

//     Queue::assertPushed(CachePastRoundPerformanceByPublicKey::class, 51);
// });


it('should cache the past performance for a public key', function () {
    $publicKey = 'generator';
    foreach (range(10, 14) as $round) {
        Block::factory()->create([
            'generator_public_key' => $publicKey,
            'height'               => $round * Network::delegateCount(),
        ]);
    }

    expect(Block::whereGeneratorPublicKey($publicKey)->count())->toBe(5);
    expect(Cache::tags('wallet')->has(md5("performance/$publicKey")))->toBeFalse();

    (new CacheDelegatePerformance())->handle();

    // (new CachePastRoundPerformanceByPublicKey(16, $publicKey))->handle();

    expect(Cache::tags('wallet')->has(md5("performance/$publicKey")))->toBeTrue();
    expect((new WalletCache())->getPerformance($publicKey))->toBe([
        true,
        true,
        true,
        true,
        true,
    ]);
});

// it('should cache end of a round missed blocks for a public key ', function () {
//     $publicKey = 'generator';
//     foreach (range(10, 13) as $round) {
//         Block::factory()->create([
//             'generator_public_key' => $publicKey,
//             'height'               => $round * Network::delegateCount(),
//         ]);
//     }

//     expect(Block::whereGeneratorPublicKey($publicKey)->count())->toBe(4);
//     expect(Cache::tags('wallet')->has(md5("performance/$publicKey")))->toBeFalse();

//     (new CachePastRoundPerformanceByPublicKey(16, $publicKey))->handle();

//     expect(Cache::tags('wallet')->has(md5("performance/$publicKey")))->toBeTrue();
//     expect((new WalletCache())->getPerformance($publicKey))->toBe([
//         true,
//         true,
//         true,
//         true,
//         false,
//     ]);
// });
