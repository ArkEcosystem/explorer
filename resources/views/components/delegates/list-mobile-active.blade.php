<div class="space-y-8 divide-y table-list-mobile">
    @foreach ($delegates as $delegate)
        <div class="space-y-3 table-list-mobile-row">
            <div>
                @lang('general.delegates.rank')

                <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                <div wire:loading.class="hidden">{{ $delegate->rank() }}</div>
            </div>

            <div>
                @lang('general.delegates.name')

                <div class="flex flex-row items-center space-x-3">
                    <div wire:loading.class="h-6 rounded-full w-11 bg-theme-secondary-300 animate-pulse"></div>
                    <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                </div>

                <x-general.address :address="$delegate->username()" />
            </div>

            <div>
                @lang('general.delegates.status')

                <div class="flex flex-row items-center space-x-3">
                    <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                    <div wire:loading.class="hidden">{{-- @TODO: Missed Blocks for Last 5 Rounds--}}</div>
                </div>
            </div>

            <div>
                @lang('general.delegates.votes')

                <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                <div wire:loading.class="hidden">
                    {{ $delegate->votes() }}
                    <span>{{ $delegate->votesPercentage() }}</span>
                </div>
            </div>

            @if (Network::usesMarketSquare())
                <div>
                    @lang('general.delegates.profile')

                    {{--@TODO: MSQ Profile--}}
                </div>

                <div>
                    @lang('general.delegates.commission')

                    {{--@TODO: MSQ Commission--}}
                </div>
            @endif

            <div>
                @lang('general.delegates.productivity')

                <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                <div wire:loading.class="hidden">{{ $delegate->productivity() }}</div>
            </div>
        </div>
    @endforeach
</div>
