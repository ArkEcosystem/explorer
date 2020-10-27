@php($iconType = $transaction->iconType())

<div wire:key="{{ $transaction->id() }}">
    @php($address = null)
    @php($text = trans('general.transaction.'.$iconType))

    <div @if ($withLoading ?? false) wire:loading.class="hidden" @endif>
        @if ($transaction->isUnknown())
            @php($address = $transaction->recipient() ?? $transaction->sender())
            <x-general.address :address="$address" />
        @elseif ($transaction->isTransfer())
            @php($address = $transaction->recipient() ?? $transaction->sender())
            <x-general.address :address="$address" />
        @elseif ($transaction->isVote())
            @php($voteTransaction = $transaction->voted())

            <x-general.username :transaction="$voteTransaction">
                <x-slot name="icon">
                    <x-transactions.icon :icon-type="$iconType" />
                </x-slot>

                <x-slot name="prefix">
                    <span class="pr-2 mr-2 font-semibold border-r text-theme-secondary-900 dark:text-theme-secondary-200 border-theme-secondary-300 dark:border-theme-secondary-800">
                        @lang('general.transaction.vote')
                    </span>
                </x-slot>
            </x-general.username>
        @elseif ($transaction->isUnvote())
            @php($unvoteTransaction = $transaction->unvoted())

            <x-general.username :transaction="$unvoteTransaction">
                <x-slot name="icon">
                    <x-transactions.icon :icon-type="$iconType" />
                </x-slot>

                <x-slot name="prefix">
                    <span class="pr-2 mr-2 font-semibold border-r text-theme-secondary-900 dark:text-theme-secondary-200 border-theme-secondary-300 dark:border-theme-secondary-800">
                        @lang('general.transaction.unvote')
                    </span>
                </x-slot>
            </x-general.username>
        @else
            <div class="flex items-center space-x-3">
                <x-transactions.icon :icon-type="$iconType" />

                <div class="font-semibold text-theme-secondary-900 dark:text-theme-secondary-200">
                    {{ $text }}
                </div>
            </div>
        @endif
    </div>

    @if ($withLoading ?? false)
        <x-general.loading-state.recipient-address :address="$address" :text="$text" />
    @endif
</div>
