<div class="space-y-8 divide-y table-list-mobile">
    @foreach ($delegates as $delegate)
        <div class="space-y-3 table-list-mobile-row">
            <div>
                @lang('pages.monitor.order')

                <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                <div wire:loading.class="hidden">{{ $delegate['order'] }}</div>
            </div>

            <div>
                @lang('pages.monitor.name')

                <div class="flex flex-row items-center space-x-3">
                    <div wire:loading.class="h-6 rounded-full w-11 bg-theme-secondary-300 animate-pulse"></div>
                    <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                </div>

                <x-general.address :address="$delegate['username']" />
            </div>

            <div>
                @lang('pages.monitor.forging_at')

                <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                <div wire:loading.class="hidden">{{ $delegate['forging_at'] }}</div>
            </div>

            <div>
                @lang('pages.monitor.status')

                <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                <div wire:loading.class="hidden">{{ $delegate['status'] }}</div>
            </div>

            <div>
                @lang('pages.monitor.block_id')

                <div wire:loading.class="w-full h-5 rounded-full bg-theme-secondary-300 animate-pulse"></div>
                <div wire:loading.class="hidden">{{ $delegate['last_block'] }}</div>
            </div>
        </div>
    @endforeach
</div>
