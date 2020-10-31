<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\BlockRepository;
use App\Models\Block;
use Illuminate\Support\Facades\Cache;

final class BlockRepositoryWithCache implements BlockRepository
{
    private BlockRepository $blocks;

    public function __construct(BlockRepository $blocks)
    {
        $this->blocks = $blocks;
    }

    public function findByHeight(int $height): Block
    {
        return Cache::remember(
            "repository:findByHeight.{$height}",
            60,
            fn () => $this->blocks->findByHeight($height)
        );
    }
}
