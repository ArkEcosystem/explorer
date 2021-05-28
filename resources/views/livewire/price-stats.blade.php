
<x-stats.stat
    class="flex-grow justify-between"
    icon="app-price"
    wire:poll.60s
    :disabled="! Network::canBeExchanged()"
>
    <x-slot name="body">
        <div class="flex flex-grow">
            <div class="flex flex-col justify-between h-full">
                <div class="flex">
                    <span class="text-sm font-semibold leading-none whitespace-nowrap dark:text-theme-secondary-600 text-theme-secondary-500">@lang('general.price')</span>
                    @if (Network::canBeExchanged())
                        <a class="pl-3 ml-3 text-sm font-semibold leading-none whitespace-nowrap border-l link border-theme-secondary-300 dark:border-theme-secondary-800" href="{{ route('statistics') }}">
                            @lang('actions.view_statistics')
                        </a>
                    @endif
                </div>

                @if (Network::canBeExchanged())
                    <div class="flex space-x-3">
                        <span class="font-semibold leading-none whitespace-nowrap text-theme-secondary-900 dark:text-white">
                            {{ $price }}
                        </span>

                        @if ($priceChange < 0)
                            <span class="flex items-center space-x-1 text-sm font-semibold leading-none text-theme-danger-400">
                                <span>
                                    <x-ark-icon name="triangle-down" size="2xs" />
                                </span>
                                <span>
                                    <x-percentage>{{ $priceChange * 100 * -1 }}</x-percentage>
                                </span>
                            </span>
                        @else
                            <span class="flex items-center space-x-1 text-sm font-semibold leading-none text-theme-success-600">
                                <span>
                                    <x-ark-icon name="triangle-up" size="2xs" />
                                </span>
                                <span>
                                    <x-percentage>{{ $priceChange * 100 }}</x-percentage>
                                </span>
                            </span>
                        @endif
                    </div>
                @else
                    <span class="font-semibold leading-none whitespace-nowrap dark:text-theme-secondary-600 text-theme-secondary-500">
                        @lang('general.not_available')
                    </span>
                @endif
            </div>

            <div class="hidden flex-grow justify-end lg:flex" >
                <div
                    wire:key="{{ Settings::currency() }}"
                    class="ml-6"
                    x-data="PriceChart(
                        {{ $historical->values()->toJson() }},
                        {{ $historical->keys()->toJson() }},
                        {{ $priceChange === null ? 0 : $priceChange }},
                        {{ ! Network::canBeExchanged() ? 'true' : 'false' }},
                        {{ Settings::usesDarkTheme() ? 'true' : 'false' }},
                        '{{ time() }}'
                    )"
                    x-init="init"
                    @toggle-dark-mode.window="toggleDarkMode"
                >
                    <div class="block" wire:ignore>
                        <canvas x-ref="chart" class="w-full h-full" width="120" height="40" ></canvas>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>
</x-stats.stat>


