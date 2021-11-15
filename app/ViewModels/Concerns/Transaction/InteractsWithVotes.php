<?php

declare(strict_types=1);

namespace App\ViewModels\Concerns\Transaction;

use App\Facades\Wallets;
use App\ViewModels\WalletViewModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait InteractsWithVotes
{
    public function voted(): WalletViewModel|null
    {
        if (! $this->isVote()) {
            return null;
        }

        $publicKey = collect(Arr::get($this->transaction->asset ?? [], 'votes'))
            ->filter(fn ($vote) => Str::startsWith($vote, '+'))
            ->first();

        return new WalletViewModel(Wallets::findByPublicKey(substr($publicKey, 1)));
    }

    public function unvoted(): WalletViewModel|null
    {
        if (! $this->isUnvote()) {
            return null;
        }

        $publicKey = collect(Arr::get($this->transaction->asset ?? [], 'votes'))
            ->filter(fn ($vote) => Str::startsWith($vote, '-'))
            ->first();

        return new WalletViewModel(Wallets::findByPublicKey(substr($publicKey, 1)));
    }
}
