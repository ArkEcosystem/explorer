<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Wallet;
use App\Services\QRCode;
use App\ViewModels\ViewModelFactory;
use Illuminate\View\View;
use Livewire\Component;

final class WalletQrCode extends Component
{
    public bool $isOpen = false;

    public string $address;

    public ?string $amount = null;

    public ?string $smartbridge = null;

    /** @phpstan-ignore-next-line */
    protected $listeners = ['toggleQrCode'];

    public function render(): View
    {
        return view('livewire.wallet-qr-code', [
            'wallet' => ViewModelFactory::make(Wallet::whereAddress($this->address)->firstOrFail()),
        ]);
    }

    // @codeCoverageIgnoreStart
    public function updated(string $propertyName): void
    {
        $this->validateOnly($propertyName, [
            'amount'      => ['numeric', 'min:0.00000001'],
            'smartbridge' => ['string', 'max:255'],
        ]);
    }

    // @codeCoverageIgnoreEnd

    public function toggleQrCode(): void
    {
        $this->isOpen = ! $this->isOpen;

        if ($this->isOpen) {
            $this->amount      = null;
            $this->smartbridge = null;
        }
    }

    public function getWalletUriProperty(): string
    {
        $uri  = 'ark:'.$this->address;
        $data = http_build_query([
            'amount'      => $this->amount ?: null,
            'vendorField' => $this->smartbridge ?: null,
        ]);

        if (! $data) {
            return $uri;
        }

        return $uri.'?'.$data;
    }

    public function getCodeProperty(): string
    {
        return QRCode::generate($this->walletUri);
    }
}
