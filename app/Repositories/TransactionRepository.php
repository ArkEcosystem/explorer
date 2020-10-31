<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Concerns\ManagesCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

final class TransactionRepository
{
    use ManagesCache;

    public function allByWallet(string $address, string $publicKey): Collection
    {
        return Transaction::query()
            ->where(fn ($query): Builder   => $query->where('sender_public_key', $publicKey))
            ->orWhere(fn ($query): Builder => $query->where('recipient_id', $address))
            ->orWhere(fn ($query): Builder => $query->whereJsonContains('asset->payments', [['recipientId' => $address]]))
            ->get();
    }

    public function allBySender(string $publicKey): Collection
    {
        return Transaction::where('sender_public_key', $publicKey)->get();
    }

    public function allByRecipient(string $address): Collection
    {
        return Transaction::query()
            ->orWhere(fn ($query): Builder => $query->where('recipient_id', $address))
            ->orWhere(fn ($query): Builder => $query->whereJsonContains('asset->payments', [['recipientId' => $address]]))
            ->get();
    }
}
