@php($iconType = $transaction->iconType())

<div wire:key="{{ $transaction->id() }}">
    <div>
        @if ($transaction->isTransfer() || $transaction->isUnknown())
            <x-general.identity :model="$transaction->recipient()" />
        @elseif ($transaction->isVote())
            <x-general.identity :model="$transaction->voted()">
                <x-slot name="icon">
                    <x-transactions.icon :icon-type="$iconType" />
                </x-slot>

                <x-slot name="prefix">
                    <span class="pr-2 mr-2 font-semibold border-r text-theme-secondary-900 dark:text-theme-secondary-200 border-theme-secondary-300 dark:border-theme-secondary-800">
                        @lang('general.transaction.vote')
                    </span>
                </x-slot>
            </x-general.identity>
        @elseif ($transaction->isUnvote())
            <x-general.identity :model="$transaction->unvoted()">
                <x-slot name="icon">
                    <x-transactions.icon :icon-type="$iconType" />
                </x-slot>

                <x-slot name="prefix">
                    <span class="pr-2 mr-2 font-semibold border-r text-theme-secondary-900 dark:text-theme-secondary-200 border-theme-secondary-300 dark:border-theme-secondary-800">
                        @lang('general.transaction.unvote')
                    </span>
                </x-slot>
            </x-general.identity>
        @else
            <div class="flex items-center space-x-3">
                <x-transactions.icon :icon-type="$iconType" />

                <div class="font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">
                    @lang('general.transaction.'.$iconType)
                </div>
            </div>
        @endif
    </div>
</div>
