<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

final class WalletFactory extends Factory
{
    protected $model = Wallet::class;

    private static $wallets;

    public function __construct()
    {
        if (self::$wallets === null) {
            self::$wallets = json_decode(file_get_contents(base_path('tests/fixtures/wallets.json')), true);
        }
    }

    public function definition()
    {
        $wallet = $this->faker->randomElement(self::$wallets);

        return [
            'id'                => $this->faker->uuid,
            'address'           => $wallet['address'],
            'public_key'        => $wallet['publicKey'],
            'balance'           => $this->faker->numberBetween(1, 1000) * 1e8,
            'nonce'             => $this->faker->numberBetween(1, 1000),
            'attributes'        => [
                'secondPublicKey' => $this->faker->uuid,
                'delegate'        => [
                    'username'       => $this->faker->uuid,
                    'voteBalance'    => $this->faker->numberBetween(1, 1000) * 1e8,
                    'producedBlocks' => $this->faker->numberBetween(1, 1000),
                    'missedBlocks'   => $this->faker->numberBetween(1, 1000),
                ],
            ],
        ];
    }
}
