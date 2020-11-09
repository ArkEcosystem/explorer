<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Services\QRCode;
use Livewire\Component;

final class WalletQrCode extends Component
{
    public bool $isOpen = false;

    public string $address;

    public ?int $amount = null;

    public ?string $smartbridge = null;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['toggleQrCode'];

    // @codeCoverageIgnoreStart
    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, [
            'amount'      => ['required', 'numeric'],
            'smartbridge' => ['required', 'string', 'max:255'],
        ]);
    }

    // @codeCoverageIgnoreEnd

    public function toggleQrCode(): void
    {
        $this->isOpen = ! $this->isOpen;
    }

    public function getWalletUriProperty(): string
    {
        $data = [
            'recipient'   => $this->address,
            'amount'      => $this->amount,
            'vendorField' => $this->smartbridge,
        ];

        return 'ark:transfer?'.http_build_query($data);
    }

    public function getCodeProperty(): string
    {

        return QRCode::generate($this->walletUri);
    }
}
