<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\BlockRepository as Contract;
use App\Models\Block;

final class BlockRepository implements Contract
{
    public function findById(int|string $id): Block
    {
        return Block::findOrFail($id);
    }

    public function findByHeight(int|string $height): Block
    {
        return Block::where('height', $height)->firstOrFail();
    }

    public function findByIdentifier(int|string $identifier): Block
    {
        return Block::query()
            ->where('id', $identifier)
            ->orWhere('height', (int) $identifier)
            ->firstOrFail();
    }
}
