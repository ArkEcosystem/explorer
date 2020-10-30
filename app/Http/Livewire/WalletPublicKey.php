<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use Livewire\Component;

final class WalletPublicKey extends Component
{
    public bool $isOpen = false;

    public string $publicKey;

    public int $amount = 10;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['togglePublicKey'];

    public function togglePublicKey(): void
    {
        $this->isOpen = ! $this->isOpen;
    }
}
