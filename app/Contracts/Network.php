<?php

declare(strict_types=1);

namespace App\Contracts;

interface Network
{
    public function name(): string;

    public function alias(): string;

    public function currency(): string;

    public function currencySymbol(): string;

    public function confirmations(): int;

    public function knownWallets(): array;

    public function canBeExchanged(): bool;

    public function host(): string;
}
