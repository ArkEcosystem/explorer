<?php

declare(strict_types=1);

namespace App\ViewModels\Concerns\Block;

use App\DTO\MemoryWallet;
use Illuminate\Support\Arr;

trait HasDelegate
{
    public function delegate(): ?MemoryWallet
    {
        return MemoryWallet::fromPublicKey($this->block->generator_public_key);
    }

    public function address(): string
    {
        return Arr::get($this->delegate() ?? [], 'address', 'Genesis');
    }

    public function username(): string
    {
        return $this->delegate()->username() ?? 'Genesis';
    }
}
