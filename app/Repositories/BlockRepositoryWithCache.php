<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\BlockRepository;
use App\Models\Block;
use App\Repositories\Concerns\ManagesCache;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

final class BlockRepositoryWithCache implements BlockRepository
{
    use ManagesCache;

    public function __construct(private readonly BlockRepository $blocks)
    {
    }

    public function findById(int|string $id): Block
    {
        return $this->remember(fn () => $this->blocks->findById($id));
    }

    public function findByHeight(int|string $height): Block
    {
        return $this->remember(fn () => $this->blocks->findByHeight($height));
    }

    public function findByIdentifier(int|string $identifier): Block
    {
        return $this->remember(fn () => $this->blocks->findByIdentifier($identifier));
    }

    private function getCache(): TaggedCache
    {
        return Cache::tags('blocks');
    }
}
