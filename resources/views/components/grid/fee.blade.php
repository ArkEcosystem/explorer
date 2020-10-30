<x-details.generic :title="trans('general.transaction.fee')" icon="app-fee">
    <x-currency>{{ $transaction->fee() }}</x-currency>
</x-details.generic>
