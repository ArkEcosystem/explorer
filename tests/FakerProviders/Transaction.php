<?php

declare(strict_types=1);

namespace Tests\FakerProviders;

use Faker\Provider\Base;

final class Transaction extends Base
{
    public function transactionId($length = 64): string
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
