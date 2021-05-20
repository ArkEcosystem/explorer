<div class="bg-white dark:bg-theme-secondary-900">
    <x-ark-container container-class="flex flex-wrap">
        <div class="flex py-4 px-8 w-full rounded-lg border border-theme-secondary-300">
            <div class="flex flex-col justify-between space-y-4 w-full sm:flex-row sm:space-y-0">
                <div class="flex justify-start">
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.voting_for')"
                        icon="app-transactions.vote"
                        :text="$vote->username()"
                        :url="route('wallet', $vote->address())"
                        wrapper-class="border-r-0 border-none"
                        icon-breakpoint="hidden md:flex"
                    />
                </div>

                <div class="flex w-full lg:justify-end sm:w-auto">
                    <div class="grid grid-cols-2 w-full sm:w-auto">
                        @if(! $vote->isResigned())
                            <x-general.entity-header-item
                                :title="trans('pages.wallet.rank')"
                                title-wrapper-class="lg:justify-end"
                                wrapper-class="border-r border-theme-secondary-300 sm:pr-4 lg:text-right"
                                without-single-icon
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
                        without-single-icon
                        title-wrapper-class="lg:justify-end"
                        content-class="flex flex-col flex-1 justify-between ml-4 font-semibold truncate lg:text-right lg:ml-0"
                    >
                        <x-slot name="text">
                            @if($vote->isResigned())
                                <span class="text-theme-danger-400">@lang('pages.delegates.resigned')</span>
                            @elseif($vote->rank() > 51)
                                <span class="text-theme-secondary-500">@lang('pages.delegates.standby')</span>
                            @else
                                <span class="text-theme-success-600">@lang('pages.delegates.active')</span>
                            @endif
                        </x-slot>
                    </x-general.entity-header-item>
                    </div>
                </div>
            </div>
        </div>
    </x-ark-container>
</div>
