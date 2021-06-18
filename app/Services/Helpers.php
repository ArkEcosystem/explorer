<?php

declare(strict_types=1);

namespace App\Services;

final class Helpers
{
    /**
     * Blends multiple parameters and creates an unique 8 chars string.
     * Useful for wire:keys.
     */
    public static function blend(...$params): string
    {
        return substr(md5(implode('*', $params)), 0, 10);
    }
}
