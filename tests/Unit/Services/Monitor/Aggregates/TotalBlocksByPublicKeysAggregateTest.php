<?php

declare(strict_types=1);

use App\Models\Block;

use App\Services\Monitor\Aggregates\TotalBlocksByPublicKeysAggregate;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should aggregate the total amount forged by the given public keys', function () {
    Block::factory(10)->create([
        'generator_public_key' => 'generator',
    ])->pluck('generator_public_key')->toArray();

    $result = (new TotalBlocksByPublicKeysAggregate())->aggregate(['generator']);

    expect($result)->toBeArray();
});
