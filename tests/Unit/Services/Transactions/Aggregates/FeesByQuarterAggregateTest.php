<?php

declare(strict_types=1);

use Carbon\Carbon;
use App\Models\Transaction;
use App\Services\Timestamp;
use Illuminate\Support\Collection;

use function Tests\configureExplorerDatabase;
use function Spatie\Snapshots\assertMatchesSnapshot;
use App\Services\Transactions\Aggregates\FeesByQuarterAggregate;

beforeEach(fn () => configureExplorerDatabase());

it('should aggregate the fees for 3 months', function () {
    Carbon::setTestNow(Carbon::now());

    $start = Transaction::factory(10)->create([
        'fee'       => '100000000',
        'timestamp' => Timestamp::now()->subDays(90)->startOfDay()->unix(),
    ])->sortByDesc('timestamp');

    $end = Transaction::factory(10)->create([
        'fee'       => '100000000',
        'timestamp' => Timestamp::now()->endOfDay()->unix(),
    ])->sortByDesc('timestamp');

    $result = (new FeesByQuarterAggregate())->aggregate(
        Timestamp::fromGenesis($start->last()->timestamp)->startOfDay(),
        Timestamp::fromGenesis($end->last()->timestamp)->endOfDay()
    );

    expect($result)->toBeInstanceOf(Collection::class);
    assertMatchesSnapshot($result);
});
