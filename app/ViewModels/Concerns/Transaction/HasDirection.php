<?php

declare(strict_types=1);

namespace App\ViewModels\Concerns\Transaction;

use Illuminate\Support\Arr;

trait HasDirection
{
    public function isSent(string $address): bool
    {
        return $this->direction->isSent($address);
    }

    public function isSentToSelf(string $address): bool
    {
        if (! $this->isTransfer() && ! $this->isMultiPayment()) {
            return false;
        }

        if ($this->sender() !== null && $address !== $this->sender()->address) {
            return false;
        }
        if (!$this->isTransfer()) {
            return collect(Arr::get($this->transaction, 'asset.payments', []))
                ->some(fn ($payment) => $address === $payment['recipientId']);
        }
        if ($this->recipient() === null) {
            return collect(Arr::get($this->transaction, 'asset.payments', []))
                ->some(fn ($payment) => $address === $payment['recipientId']);
        }
        if ($address !== $this->recipient()->address) {
            return collect(Arr::get($this->transaction, 'asset.payments', []))
                ->some(fn ($payment) => $address === $payment['recipientId']);
        }
        return true;
    }

    public function isReceived(string $address): bool
    {
        return $this->direction->isReceived($address);
    }
}
