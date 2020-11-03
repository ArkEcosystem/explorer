<?php

declare(strict_types=1);

namespace App\Services\Blockchain\Networks\ARK;

use App\Contracts\Network;
use App\Services\Cache\WalletCache;
use ArkEcosystem\Crypto\Networks\Devnet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

final class Development implements Network
{
    public function name(): string
    {
        return 'ARK Development Network';
    }

    public function alias(): string
    {
        return 'devnet';
    }

    public function currency(): string
    {
        return 'DARK';
    }

    public function currencySymbol(): string
    {
        return 'DѦ';
    }

    public function confirmations(): int
    {
        return 51;
    }

    public function knownWallets(): array
    {
        return (new WalletCache())->setKnown(
            fn () => Http::get('https://raw.githubusercontent.com/ArkEcosystem/common/master/mainnet/known-wallets-extended.json')->json()
        );
    }

    public function canBeExchanged(): bool
    {
        return false;
    }

    public function host(): string
    {
        return 'https://dwallets.ark.io/api';
    }

    public function usesMarketsquare(): bool
    {
        return false;
    }

    public function epoch(): Carbon
    {
        return Carbon::parse(Devnet::new()->epoch());
    }

    public function delegateCount(): int
    {
        return 51;
    }

    public function blockTime(): int
    {
        return 8;
    }

    public function blockReward(): int
    {
        return 2;
    }

    public function config(): \BitWasp\Bitcoin\Network\Network
    {
        return new Devnet();
    }
}
