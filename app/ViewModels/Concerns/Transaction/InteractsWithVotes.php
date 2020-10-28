<?php

declare(strict_types=1);

namespace App\ViewModels\Concerns\Transaction;

use App\Models\Wallet;
use App\ViewModels\ViewModelFactory;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

trait InteractsWithVotes
{
    public function voted(): ?Wallet
    {
        if (! $this->isVote()) {
            return null;
        }

        $publicKey = collect(Arr::get($this->transaction->asset ?? [], 'votes'))
            ->filter(fn ($vote) => Str::startsWith($vote, '+'))
            ->first();

        return Cache::remember(
            "transaction:wallet:{$publicKey}",
            Carbon::now()->addHour(),
            fn () => ViewModelFactory::make(Wallet::where('public_key', substr($publicKey, 1))->firstOrFail())
        );
    }

    public function unvoted(): ?Wallet
    {
        if (! $this->isUnvote()) {
            return null;
        }

        $publicKey = collect(Arr::get($this->transaction->asset ?? [], 'votes'))
            ->filter(fn ($vote) => Str::startsWith($vote, '-'))
            ->first();

        return Cache::remember(
            "transaction:wallet:{$publicKey}",
            Carbon::now()->addHour(),
            fn () => ViewModelFactory::make(Wallet::where('public_key', substr($publicKey, 1))->firstOrFail())
        );
    }
}
