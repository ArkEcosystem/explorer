<?php

declare(strict_types=1);

use App\Models\Transaction;

use App\Services\Timestamp;
use App\Services\Transactions\Aggregates\FeeByRangeAggregate;
use Illuminate\Support\Collection;

use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should determine if the transaction is sent', function () {
    $start = Transaction::factory(10)->create([
        'fee'       => 1e8,
        'timestamp' => 112982056,
    ])->sortByDesc('timestamp');

    $end = Transaction::factory(10)->create([
        'fee'       => 1e8,
        'timestamp' => 122982056,
    ])->sortByDesc('timestamp');

    $result = FeeByRangeAggregate::aggregate(
    Timestamp::fromGenesis($start->last()->timestamp)->startOfDay(),
    Timestamp::fromGenesis($end->last()->timestamp)->endOfDay()
    );

    expect($result)->toBeInstanceOf(Collection::class);
    expect($result->toArray())->toBe([
        '2021-02-11' => '10',
        '2020-10-19' => '10',
    ]);
});
