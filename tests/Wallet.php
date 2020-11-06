<?php

declare(strict_types=1);

namespace Tests;

use Faker\Generator;
use Faker\Provider\Base;

final class Wallet extends Base
{
    private static $wallets;

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);

        if (self::$wallets === null) {
            self::$wallets = json_decode(file_get_contents(base_path('tests/fixtures/wallets.json')), true);
        }
    }

    public function wallet()
    {
        return static::randomElement(self::$wallets);
    }
}
