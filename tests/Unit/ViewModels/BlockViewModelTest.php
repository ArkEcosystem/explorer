<?php

declare(strict_types=1);

use App\Models\Block;
use App\ViewModels\BlockViewModel;

use function Spatie\Snapshots\assertMatchesSnapshot;
use function Tests\configureExplorerDatabase;

beforeEach(function () {
    configureExplorerDatabase();

    $previousBlock = Block::factory()->create(['height' => 1]);

    $this->subject = new BlockViewModel(Block::factory()->create([
        'previous_block' => $previousBlock->id,
        'height'         => 10000,
        'total_amount'   => 50 * 1e8,
        'total_fee'      => 48 * 1e8,
        'reward'         => 2 * 1e8,
    ]));
});

it('should get the url', function () {
    expect($this->subject->url())->toBeString();
    expect($this->subject->url())->toBe(route('block', $this->subject->id()));
});

it('should get the timestamp', function () {
    expect($this->subject->timestamp())->toBeString();
    expect($this->subject->timestamp())->toBe('19 Oct 2020 (04:54:16)');
});

it('should get the height', function () {
    expect($this->subject->height())->toBeString();
    expect($this->subject->height())->toBe('10,000');
});

it('should get the amount', function () {
    expect($this->subject->amount())->toBeString();

    assertMatchesSnapshot($this->subject->amount());
});

it('should get the fee', function () {
    expect($this->subject->fee())->toBeString();

    assertMatchesSnapshot($this->subject->fee());
});

it('should get the reward', function () {
    expect($this->subject->reward())->toBeString();

    assertMatchesSnapshot($this->subject->reward());
});

it('should get the amount as fiat', function () {
    expect($this->subject->amountFiat())->toBeNull();
});

it('should get the fee as fiat', function () {
    expect($this->subject->feeFiat())->toBeNull();
});

it('should get the reward as fiat', function () {
    expect($this->subject->rewardFiat())->toBeNull();
});

it('should get the delegate', function () {
    expect($this->subject->delegate())->toBeString();
    expect($this->subject->delegate())->not()->toBe('n/a');
});

it('should fail to get the delegate', function () {
    $this->subject = new BlockViewModel(Block::factory()->create([
        'generator_public_key' => 'unknown',
    ]));

    expect($this->subject->delegate())->toBeString();
    expect($this->subject->delegate())->toBe('n/a');
});
