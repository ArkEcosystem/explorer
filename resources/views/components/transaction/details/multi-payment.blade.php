<x-grid.sender :model="$transaction" />

<x-details.generic :title="trans('general.transaction.recipient')" icon="app-volume">
    <x-number>{{ $transaction->recipientsCount() }}</x-number> @lang('general.transaction.recipients')
</x-details.generic>

<x-grid.block-id :model="$transaction" />

<x-grid.timestamp :model="$transaction" />

<x-grid.vendor-field :model="$transaction" without-border />

<x-grid.nonce :model="$transaction" without-border />
