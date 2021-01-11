<?php

declare(strict_types=1);

use App\Models\Wallet;

it('should throw an exception on invalid sorting scope', function () {
    Wallet::factory(5)->create();

    Wallet::scoped('foo');
})->throws(InvalidArgumentException::class, '$scope must be an instance of Scope');