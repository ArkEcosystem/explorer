<x-general.entity-header-item
    :title="trans('pages.transaction.transaction_type')"
    icon="app-transactions-amount"
>
    <x-slot name="text">
        {{ $transaction->entityType() }}
    </x-slot>
</x-general.entity-header-item>

<x-general.entity-header-item
    :title="trans('pages.transaction.name')"
    icon="app-transactions-amount"
>
    <x-slot name="text">
        {{ $transaction->entityName() }}
    </x-slot>
</x-general.entity-header-item>

<x-general.entity-header-item
    :title="trans('pages.transaction.category')"
    icon="app-transactions-amount"
>
    <x-slot name="text">
        {{ $transaction->entityCategory() }}
    </x-slot>
</x-general.entity-header-item>

<x-general.entity-header-item
    :title="trans('pages.transaction.ipfs_hash')"
    icon="app-transactions-amount"
>
    <x-slot name="text">
        {{ $transaction->entityHash() }}
    </x-slot>
</x-general.entity-header-item>
