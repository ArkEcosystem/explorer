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

    public function isSentToSelf(): bool
    {
        if ($this->isTransfer() && $this->sender()->address === $this->recipient()->address) {
            return true;
        }

        return collect(Arr::get($this->transaction->asset ?? [], 'payments', []))
            ->some(function ($payment): bool {
                $sender = $this->sender();

                return $sender !== null && $sender->address === $payment['recipientId'];
            });
    }

    public function isReceived(string $address): bool
    {
        return $this->direction->isReceived($address);
    }
}
