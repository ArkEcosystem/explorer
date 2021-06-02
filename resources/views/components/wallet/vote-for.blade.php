<div class="w-full pb-8 bg-white dark:bg-theme-secondary-900 content-container">
    <div class="flex w-full px-8 py-4 border rounded-xl border-theme-secondary-300 dark:border-theme-secondary-800">
        <div class="flex flex-col justify-between w-full space-y-6 sm:flex-row sm:space-y-0">
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
                @if(! $vote->isResigned())
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.rank')"
                        without-icon
                        content-class="space-y-2 border-r pr-7 sm:text-right border-theme-secondary-300 dark:border-theme-secondary-800 sm:border-r-0 sm:pr-0"
                    >
                        <x-slot name="text">
                            @if ($vote->isResigned())
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
                    content-class="sm:-ml-4 sm:text-right "
                >
                    <x-slot name="text">
                        @if($vote->isResigned())
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
