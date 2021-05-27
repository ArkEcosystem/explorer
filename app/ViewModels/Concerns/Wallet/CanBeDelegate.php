<?php

declare(strict_types=1);

namespace App\ViewModels\Concerns\Wallet;

use App\Facades\Network;
use App\Services\Cache\WalletCache;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait CanBeDelegate
{
    public function isDelegate(): bool
    {
        return Arr::has($this->wallet, 'attributes.delegate');
    }

    public function isResigned(): bool
    {
        return Arr::has($this->wallet, 'attributes.delegate.resigned');
    }

    public function resignationId(): ?string
    {
        if (is_null($this->wallet->public_key)) {
            return null;
        }

        if (! Arr::has($this->wallet, 'attributes.delegate.resigned')) {
            return null;
        }

        return (new WalletCache())->getResignationId($this->wallet->public_key);
    }

    public function username(): ?string
    {
        $knownWallet = $this->findWalletByKnown();

        if (! is_null($knownWallet)) {
            return $knownWallet['name'];
        }

        return Arr::get($this->wallet, 'attributes.delegate.username');
    }

    /**
     * @codeCoverageIgnore
     */
    public function rank(): ?int
    {
        return Arr::get($this->wallet, 'attributes.delegate.rank', 0);
    }

    public function delegateStatusColors(): Collection
    {
        if ($this->isResigned()) {
            return collect(["firstColor" => "text-theme-secondary-500 border-theme-secondary-500 dark:text-theme-secondary-800 dark:border-theme-secondary-800", "secondColor" => "text-theme-secondary-500 border-theme-secondary-500 dark:text-theme-secondary-800 dark:border-theme-secondary-800"]);
        }

        if ($this->rank() > Network::delegateCount()) {
            return collect(["firstColor" => "text-theme-secondary-900 border-theme-secondary-900", "secondColor" => "text-theme-secondary-500 border-theme-secondary-500 dark:text-theme-secondary-800 dark:border-theme-secondary-800"]);
        }

        return collect(["firstColor" => "text-theme-secondary-900 border-theme-secondary-900", "secondColor" => "text-theme-success-600 border-theme-success-600"]);
    }
}
