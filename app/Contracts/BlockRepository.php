<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Block;

interface BlockRepository
{
    public function findById(int|string $id): Block;

    public function findByHeight(int|string $height): Block;

    public function findByIdentifier(int|string $height): Block;
}
