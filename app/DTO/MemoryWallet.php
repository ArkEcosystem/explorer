<?php

declare(strict_types=1);

namespace App\DTO;

use App\Services\Cache\WalletCache;
use App\Services\Identity;

final class MemoryWallet
{
    public string $address;

    public ?string $publicKey = null;

    private function __construct(string $address, ?string $publicKey = null)
    {
        $this->address   = $address;
        $this->publicKey = $publicKey;
    }

    public static function fromAddress(string $address)
    {
        return new static($address);
    }

    public static function fromPublicKey(string $publicKey)
    {
        // @TODO: cache the address to avoid the slow derivation
        return new static(Identity::address($publicKey), $publicKey);
    }

    public function address(): string
    {
        return $this->address;
    }

    public function publicKey(): ?string
    {
        return $this->publicKey;
    }

    public function username(): ?string
    {
        return (new WalletCache())->getUsernameByAddress($this->address);
    }
}
