<?php

declare(strict_types=1);

namespace App\Services;

use ArkEcosystem\Crypto\Identities\Address;
use ArkEcosystem\Crypto\Identities\PublicKey;

final class MultiSignature
{
    public static function address(int $min, array $publicKeys): string
    {
        return Address::fromPublicKey(PublicKey::fromMultiSignatureAsset($min, $publicKeys)->getHex());
    }
}
