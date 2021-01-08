<?php

declare(strict_types=1);

namespace App\Models\Scopes;

class BaseOrderByScope
{
    public function __construct(
        protected string $direction = 'desc',
    ) {}
}
