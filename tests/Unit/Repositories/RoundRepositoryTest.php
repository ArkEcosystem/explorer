<?php

declare(strict_types=1);

use App\Models\Round;
use App\Models\Wallet;
use App\Repositories\RoundRepository;

beforeEach(fn () => $this->subject = new RoundRepository());

it('should get all delegates for the given round', function () {
    Wallet::factory(51)->create()->each(function ($wallet) {
        Round::factory()->create([
            'round'      => '112168',
            'public_key' => $wallet->public_key,
        ]);
    });

    expect($this->subject->allByRound(112168))->toHaveCount(51);
});

it('should get the current round', function () {
    expect($this->subject->current())->toBe(Round::max('round'));
});
