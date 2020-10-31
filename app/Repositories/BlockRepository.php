<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Block;
use App\Repositories\Concerns\ManagesCache;

final class BlockRepository
{
    use ManagesCache;

    public function findByHeight(int $height): Block
    {
        return Block::where('height', $height)->firstOrFail();
    }
}
