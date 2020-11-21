<?php

declare(strict_types=1);

namespace Tests\FakerProviders;

use Faker\Provider\Base;
use Illuminate\Support\Str;

final class Block extends Base
{
    public function blockId(): string
    {
        return hash('sha256', Str::random(8));
    }

    public function payloadHash(): string
    {
        return hash('sha256', Str::random(8));
    }

    public function blockSignature(): string
    {
        return Str::limit(hash('sha512', Str::random(8)), 140);
    }
}
