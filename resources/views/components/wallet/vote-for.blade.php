@php
    $isResigned = $vote->isResigned();
@endphp

<div class="pb-8 w-full bg-white dark:bg-theme-secondary-900 content-container">
    <div class="flex py-4 px-8 w-full rounded-lg border border-theme-secondary-300 dark:border-theme-secondary-800">
        <div class="flex flex-col justify-between space-y-6 w-full sm:flex-row sm:space-y-0">
            <div class="flex justify-start">
                <div class="flex md:hidden">
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.voting_for')"
                        without-icon
                        :text="$vote->username()"
                        :url="route('wallet', $vote->address())"
                        content-class="space-y-2"
                        wrapper-class="border-none"
                    />
                </div>

                <div class="hidden md:flex">
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.voting_for')"
                        icon="app-transactions.vote"
                        :text="$vote->username()"
                        :url="route('wallet', $vote->address())"
                        wrapper-class="border-none"
                    />
                </div>
            </div>

            <div class="flex space-x-8 sm:space-x-4">
                @if(! $isResigned)
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.rank')"
                        without-icon
                        content-class="pr-8 space-y-2 border-r sm:text-right sm:mr-2 border-theme-secondary-300 dark:border-theme-secondary-800 md:border-r-0"
                    >
                        <x-slot name="text">
                            @if ($isResigned)
                                <x-details.resigned />
                            @else
                                @lang('pages.wallet.vote_rank', [$vote->rank()])
                            @endif
                        </x-slot>
                    </x-general.entity-header-item>
                @endif

                <x-general.entity-header-item
                    :title="trans('pages.wallet.status')"
                    without-icon
                    content-class="space-y-2 sm:text-right"
                >
                    <x-slot name="text">
                        @if($isResigned)
                            <span class="text-theme-danger-400">@lang('pages.delegates.resigned')</span>
                        @elseif($vote->rank() > Network::delegateCount())
                            <span class="text-theme-secondary-500 dark:text-theme-secondary-700">@lang('pages.delegates.standby')</span>
                        @else
                            <span class="text-theme-success-600">@lang('pages.delegates.active')</span>
                        @endif
                    </x-slot>
                </x-general.entity-header-item>
            </div>
        </div>
    </div>
</div>
