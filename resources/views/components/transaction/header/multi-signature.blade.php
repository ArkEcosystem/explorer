<x-general.entity-header-item
    :title="trans('pages.transaction.musig_participants')"
    icon="app-transactions-amount"
>
    <x-slot name="text">
        @lang('pages.transaction.musig_participants_text', [
            $transaction->multiSignatureMinimum(),
            $transaction->multiSignatureParticipantCount()
        ])
    </x-slot>
</x-general.amount-fiat-tooltip>
