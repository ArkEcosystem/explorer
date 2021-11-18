<?php

declare(strict_types=1);

namespace App\DTO;

use App\Services\Cache\WalletCache;
use App\Services\Monitor\Monitor;
use App\ViewModels\WalletViewModel;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

final class Slot
{
    private array $collection;

    public function __construct(array $data, Collection $roundBlocks, private int $roundNumber)
    {
        foreach ($data as $key => $value) {
            $key = Str::camel($key);

            $this->collection[$key] = $value;
        }

        $this->collection['roundNumber'] = $this->roundNumber;

        $this->collection['currentRoundBlocks'] = $roundBlocks
            ->where('generator_public_key', $data['publicKey'])
            ->count();
    }

    public function publicKey(): string
    {
        return $this->collection['publicKey'];
    }

    public function order(): int
    {
        return $this->collection['order'];
    }

    public function wallet(): WalletViewModel
    {
        return $this->collection['wallet'];
    }

    public function forgingAt(): Carbon
    {
        return $this->collection['forgingAt'];
    }

    public function lastBlock(): array
    {
        return $this->collection['lastBlock'];
    }

    public function hasForged(): bool
    {
        if ($this->isWaiting()) {
            return false;
        }

        return $this->collection['currentRoundBlocks'] >= 1;
    }

    public function justMissed(): bool
    {
        if ($this->isWaiting()) {
            return false;
        }

        return $this->collection['currentRoundBlocks'] < 1;
    }

    public function keepsMissing(): bool
    {
        if ($this->isWaiting()) {
            return false;
        }

        if ($this->getLastHeight() === 0) {
            return false;
        }

        // Since we're not waiting in current round, more than 1 round between current and last forged block means we're missing 2+ consecutive rounds
        return ($this->collection['roundNumber'] - Monitor::roundNumberFromHeight($this->getLastHeight())) > 1;
    }

    public function missedCount(): int
    {
        return (new WalletCache())->getMissedBlocks($this->collection['publicKey']);
    }

    public function isDone(): bool
    {
        return $this->collection['status'] === 'done';
    }

    public function isNext(): bool
    {
        return $this->collection['status'] === 'next';
    }

    public function isPending(): bool
    {
        return $this->collection['status'] === 'pending';
    }

    public function status(): string
    {
        return $this->collection['status'];
    }

    public function isWaiting(): bool
    {
        if ($this->isNext()) {
            return true;
        }

        if ($this->isPending()) {
            return true;
        }

        return false;
    }

    private function getLastHeight(): int
    {
        return Arr::get($this->collection['lastBlock'], 'height', 0);
    }
}
