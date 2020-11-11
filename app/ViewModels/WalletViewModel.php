<?php

declare(strict_types=1);

namespace App\ViewModels;

use App\Actions\CacheNetworkSupply;
use App\Contracts\ViewModel;
use App\Models\Wallet;
use App\Services\ExchangeRate;
use App\Services\Timestamp;
use Mattiasgeniar\Percentage\Percentage;

final class WalletViewModel implements ViewModel
{
    use Concerns\Wallet\CanBeCold;
    use Concerns\Wallet\CanBeEntity;
    use Concerns\Wallet\CanBeDelegate;
    use Concerns\Wallet\CanForge;
    use Concerns\Wallet\CanVote;
    use Concerns\Wallet\HasType;
    use Concerns\Wallet\HasVoters;
    use Concerns\Wallet\InteractsWithMarketSquare;

    private Wallet $wallet;

    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function url(): string
    {
        return route('wallet', $this->wallet->address);
    }

    public function address(): string
    {
        return $this->wallet->address;
    }

    public function publicKey(): ?string
    {
        return $this->wallet->public_key;
    }

    public function balance(): float
    {
        return $this->wallet->balance->toFloat();
    }

    public function balanceFiat(): string
    {
        return ExchangeRate::convert($this->wallet->balance->toFloat(), Timestamp::now()->unix());
    }

    public function balancePercentage(): float
    {
        return Percentage::calculate($this->wallet->balance->toNumber(), CacheNetworkSupply::execute());
    }

    public function nonce(): int
    {
        return $this->wallet->nonce->toNumber();
    }
}
