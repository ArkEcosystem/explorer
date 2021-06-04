<?php

declare(strict_types=1);

namespace App\Services\Search\Traits;

use App\Enums\SQLEnum;
use App\Facades\Network;
use ArkEcosystem\Crypto\Identities\Address;

trait ValidatesTerm
{
    protected function couldBeATransactionID(string $term): bool
    {
        return $this->is64CharsLongHexadecimalString($term);
    }

    protected function couldBeABlockID(string $term): bool
    {
        return $this->is64CharsLongHexadecimalString($term);
    }

    protected function couldBeAnAddress(string $term): bool
    {
        return Address::validate($term, Network::config());
    }

    protected function couldBeAPublicKey(string $term): bool
    {
        return strlen($term) === 66 && $this->isHexadecimalString($term);
    }

    /**
     * Check if the query can be a username
     * Regex source: https://github.com/ArkEcosystem/core/blob/4e149f039b59da97d224db1c593059dbc8e0f385/packages/core-api/src/handlers/shared/schemas/username.ts.
     *
     * @return bool
     */
    protected function couldBeAUsername(string $term): bool
    {
        $regex = '/^[a-z0-9!@$&_.]+$/';

        return strlen($term) >= 1
            && strlen($term) <= 20
            && preg_match($regex, $term, $matches) > 0;
    }

    protected function couldBeHeightValue(string $term): bool
    {
        return $this->isOnlyNumbers($term) && $this->numericTermIsInRange($term);
    }

    protected function is64CharsLongHexadecimalString(string $term): bool
    {
        return $this->isOnlyNumbers($term)
            || (strlen($term) === 64 && $this->isHexadecimalString($term));
    }

    protected function isOnlyNumbers(string $term): bool
    {
        return ctype_digit($term);
    }

    protected function isHexadecimalString(string $term): bool
    {
        return ctype_xdigit($term);
    }

    /**
     * Validates that the numnber is smaller that the max size for a type integer
     * on pgsql. Searching for a bigger number will result in an SQL exception.
     *
     * @return bool
     */
    protected function numericTermIsInRange(string $term): bool
    {
        return floatval($term) <= SQLEnum::INT4_MAXVALUE;
    }
}
