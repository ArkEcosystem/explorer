<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\CoreTransactionTypeEnum;

trait AvailableTransactionType
{
    private function defaultTransactionType(): int
    {
        return CoreTransactionTypeEnum::TRANSFER;
    }

    private function availableTransactionTypes(): array
    {
        return [
            CoreTransactionTypeEnum::TRANSFER => trans('forms.statistics.transaction_types.transfer'),
            CoreTransactionTypeEnum::SECOND_SIGNATURE => trans('forms.statistics.transaction_types.second_signature'),
            CoreTransactionTypeEnum::DELEGATE_REGISTRATION => trans('forms.statistics.transaction_types.delegate_registration'),
            CoreTransactionTypeEnum::VOTE => trans('forms.statistics.transaction_types.vote'),
            CoreTransactionTypeEnum::MULTI_SIGNATURE => trans('forms.statistics.transaction_types.multi_signature'),
            CoreTransactionTypeEnum::IPFS => trans('forms.statistics.transaction_types.ipfs'),
            CoreTransactionTypeEnum::MULTI_PAYMENT => trans('forms.statistics.transaction_types.multi_payment'),
            CoreTransactionTypeEnum::DELEGATE_RESIGNATION => trans('forms.statistics.transaction_types.delegate_resignation'),
            CoreTransactionTypeEnum::TIMELOCK => trans('forms.statistics.transaction_types.timelock'),
            CoreTransactionTypeEnum::TIMELOCK_CLAIM => trans('forms.statistics.transaction_types.timelock_claim'),
            CoreTransactionTypeEnum::TIMELOCK_REFUND => trans('forms.statistics.transaction_types.timelock_refund'),
        ];
    }

    private function getTransactionTypeLabel(int $type): string | null
    {
        return collect($this->availableTransactionTypes())->get($type);
    }
}
