<?php

declare(strict_types=1);

namespace App\Http\Livewire\Concerns;

use App\Enums\StatsTransactionTypes;

trait AvailableTransactionType
{
    private function defaultTransactionType(): string
    {
        return StatsTransactionTypes::TRANSFER;
    }

    private function availableTransactionTypes(): array
    {
        return [
            StatsTransactionTypes::TRANSFER              => trans('forms.search.transaction_types.transfer'),
            StatsTransactionTypes::SECOND_SIGNATURE      => trans('forms.search.transaction_types.secondSignature'),
            StatsTransactionTypes::DELEGATE_REGISTRATION => trans('forms.search.transaction_types.delegateRegistration'),
            StatsTransactionTypes::VOTE                  => trans('forms.search.transaction_types.vote'),
            StatsTransactionTypes::VOTE_COMBINATION      => trans('forms.search.transaction_types.voteCombination'),
            StatsTransactionTypes::MULTI_SIGNATURE       => trans('forms.search.transaction_types.multiSignature'),
            StatsTransactionTypes::IPFS                  => trans('forms.search.transaction_types.ipfs'),
            StatsTransactionTypes::MULTI_PAYMENT         => trans('forms.search.transaction_types.multiPayment'),
            StatsTransactionTypes::DELEGATE_RESIGNATION  => trans('forms.search.transaction_types.delegateResignation'),
            StatsTransactionTypes::TIMELOCK              => trans('forms.search.transaction_types.timelock'),
            StatsTransactionTypes::TIMELOCK_CLAIM        => trans('forms.search.transaction_types.timelockClaim'),
            StatsTransactionTypes::TIMELOCK_REFUND       => trans('forms.search.transaction_types.timelockRefund'),
            StatsTransactionTypes::MAGISTRATE            => trans('forms.search.transaction_types.magistrate'),
        ];
    }

    private function getTransactionTypeLabel(string $type): string | null
    {
        return collect($this->availableTransactionTypes())->get($type);
    }
}
