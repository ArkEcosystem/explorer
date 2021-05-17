<div class="bg-white">
    <x-ark-container container-class="flex flex-wrap">
        <div class="flex w-full border border-theme-secondary-300 py-4 px-8 rounded-lg">
            <div class="flex flex-col sm:flex-row justify-between w-full space-y-4 sm:space-y-0">
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

                <div class="flex justify-end">
                    <x-general.entity-header-item
                        :title="trans('pages.wallet.rank')"
                        {{--wrapper-class="border-r border-theme-secondary-300 md:border-r-0 md:border-none"--}}
                        without-icon
                    >
                        <x-slot name="text">
                            @if ($wallet->isResigned())
                                <x-details.resigned />
                            @else
                                @lang('pages.wallet.vote_rank', [$vote->rank()])
                            @endif
                        </x-slot>
                    </x-general.entity-header-item>

                    <x-general.entity-header-item
                        :title="trans('pages.wallet.status')"
                        without-icon
                    >
                        <x-slot name="text">
                            @if($wallet->isResigned())
                                <span class="text-theme-danger-400">@lang('pages.delegates.resigned')</span>
                            @elseif($wallet->isDelegate())
                                <span class="text-theme-success-600">@lang('pages.delegates.active')</span>
                            @else
                                <span class="text-theme-secondary-500">@lang('pages.delegates.standby')</span>
                            @endif
                        </x-slot>
                    </x-general.entity-header-item>
                </div>
            </div>
        </div>
    </x-ark-container>
</div>
