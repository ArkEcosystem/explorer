<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CoreTransactionTypeEnum;
use App\Enums\MagistrateTransactionEntityActionEnum;
use App\Enums\MagistrateTransactionEntitySubTypeEnum;
use App\Enums\MagistrateTransactionEntityTypeEnum;
use App\Enums\MagistrateTransactionTypeEnum;
use App\Enums\TransactionTypeGroupEnum;
use App\Models\Block;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

final class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        $wallet = Wallet::factory()->create();

        return [
            'id'                => $this->faker->transactionId,
            'block_id'          => fn () => Block::factory(),
            'block_height'      => $this->faker->numberBetween(1, 10000),
            'type'              => $this->faker->numberBetween(1, 100),
            'type_group'        => $this->faker->numberBetween(1, 100),
            'sender_public_key' => fn () => $wallet->public_key,
            'recipient_id'      => fn () => $wallet->address,
            'timestamp'         => 112982056,
            'fee'               => $this->faker->numberBetween(1, 100) * 1e8,
            'amount'            => $this->faker->numberBetween(1, 100) * 1e8,
            'nonce'             => 1,
            'asset'             => [
                'ipfs' => 'QmXrvSZaDr8vjLUB9b7xz26S3kpk3S3bSc8SUyZmNPvmVo',
            ],
        ];
    }

    public function transfer(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::TRANSFER->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function secondSignature(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::SECOND_SIGNATURE->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function delegateRegistration(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::DELEGATE_REGISTRATION->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function vote(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::VOTE->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [
                'votes' => ['+publicKey'],
            ],
        ]);
    }

    public function unvote(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::VOTE->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [
                'votes' => ['-publicKey'],
            ],
        ]);
    }

    public function voteCombination(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::VOTE->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [
                'votes' => ['+publicKey', '-publicKey'],
            ],
        ]);
    }

    public function multiSignature(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::MULTI_SIGNATURE->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function ipfs(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::IPFS->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [
                'ipfs' => 'QmXrvSZaDr8vjLUB9b7xz26S3kpk3S3bSc8SUyZmNPvmVo',
            ],
        ]);
    }

    public function delegateResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::DELEGATE_RESIGNATION->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function multiPayment(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::MULTI_PAYMENT->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function timelock(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::TIMELOCK->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function timelockClaim(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::TIMELOCK_CLAIM->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function timelockRefund(): Factory
    {
        return $this->state(fn () => [
            'type'       => CoreTransactionTypeEnum::TIMELOCK_REFUND->value,
            'type_group' => TransactionTypeGroupEnum::CORE->value,
            'asset'      => [],
        ]);
    }

    public function entityRegistration(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER->value,
            ],
        ]);
    }

    public function entityResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN->value,
            ],
        ]);
    }

    public function entityUpdate(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE->value,
            ],
        ]);
    }

    public function businessEntityRegistration(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::BUSINESS->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER->value,
            ],
        ]);
    }

    public function businessEntityResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::BUSINESS->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN->value,
            ],
        ]);
    }

    public function businessEntityUpdate(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::BUSINESS->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE->value,
            ],
        ]);
    }

    public function productEntityRegistration(array $data = []): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::PRODUCT->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER->value,
                'data'    => $data,
            ],
        ]);
    }

    public function productEntityResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::PRODUCT->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN->value,
            ],
        ]);
    }

    public function productEntityUpdate(?string $registrationId = null): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'           => MagistrateTransactionEntityTypeEnum::PRODUCT->value,
                'subtype'        => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'         => MagistrateTransactionEntityActionEnum::UPDATE->value,
                'registrationId' => $registrationId,
            ],
        ]);
    }

    public function pluginEntityRegistration(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::PLUGIN->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER->value,
            ],
        ]);
    }

    public function pluginEntityResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::PLUGIN->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN->value,
            ],
        ]);
    }

    public function pluginEntityUpdate(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::PLUGIN->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE->value,
            ],
        ]);
    }

    public function moduleEntityRegistration(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::MODULE->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER->value,
            ],
        ]);
    }

    public function moduleEntityResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::MODULE->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN->value,
            ],
        ]);
    }

    public function moduleEntityUpdate(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::MODULE->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE->value,
            ],
        ]);
    }

    public function delegateEntityRegistration(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::DELEGATE->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::REGISTER->value,
            ],
        ]);
    }

    public function delegateEntityResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::DELEGATE->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::RESIGN->value,
            ],
        ]);
    }

    public function delegateEntityUpdate(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::ENTITY->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [
                'type'    => MagistrateTransactionEntityTypeEnum::DELEGATE->value,
                'subtype' => MagistrateTransactionEntitySubTypeEnum::NONE->value,
                'action'  => MagistrateTransactionEntityActionEnum::UPDATE->value,
            ],
        ]);
    }

    public function legacyBusinessRegistration(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::BUSINESS_REGISTRATION->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [],
        ]);
    }

    public function legacyBusinessResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::BUSINESS_RESIGNATION->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [],
        ]);
    }

    public function legacyBusinessUpdate(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::BUSINESS_UPDATE->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [],
        ]);
    }

    public function legacyBridgechainRegistration(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::BRIDGECHAIN_REGISTRATION->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [],
        ]);
    }

    public function legacyBridgechainResignation(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::BRIDGECHAIN_RESIGNATION->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [],
        ]);
    }

    public function legacyBridgechainUpdate(): Factory
    {
        return $this->state(fn () => [
            'type'       => MagistrateTransactionTypeEnum::BRIDGECHAIN_UPDATE->value,
            'type_group' => TransactionTypeGroupEnum::MAGISTRATE->value,
            'asset'      => [],
        ]);
    }
}
