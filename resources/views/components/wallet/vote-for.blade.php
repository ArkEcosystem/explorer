<div class="bg-white border-t-20 border-theme-secondary-100 dark:border-black dark:bg-theme-secondary-900">
    <x-ark-container container-class="flex flex-wrap">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-4">
                <x-general.entity-header-item
                    :title="trans('pages.wallet.voting_for')"
                    :avatar="$vote->address()"
                    :text="$vote->username()"
                    :url="route('wallet', $vote->address())"
                />
                <x-general.entity-header-item
                    :title="trans('pages.wallet.rank')"
                    icon="app-votes"
                >
                    <x-slot name="text">
                        @if ($wallet->isResigned())
                            <x-details.resigned />
                        @else
                            @lang('pages.wallet.vote_rank', [$vote->rank()])
                        @endif
                    </x-slot>
                </x-general.entity-header-item>
            </div>
    </x-ark-container>
</div>
