<?php

declare(strict_types=1);

namespace App\ViewModels\Concerns\Transaction;

use Illuminate\Support\Arr;

trait InteractsWithEntities
{
    public function entityType(): ?string
    {
        return Arr::get($this->transaction, 'asset.data.name');
    }

    public function entityName(): ?string
    {
        return Arr::get($this->transaction, 'asset.data.name');
    }

    public function entityCategory(): ?string
    {
        return null;
    }

    public function entityHash(): ?string
    {
        return Arr::get($this->transaction, 'asset.data.hash');
    }
}
