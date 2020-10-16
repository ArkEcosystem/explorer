{{-- TODO: Tidy up fields - review compared to design to see if they can be improved --}}
<div x-data="{ showAdvanced: true }" class="flex flex-col rounded-lg bg-white dark:bg-theme-secondary-900">
    <div class="flex items-center py-6 px-8 space-x-8">
        <div class="flex-1">
            <input
                type="text"
                placeholder="@lang('forms.search.term_placeholder')"
                class="w-full dark:text-theme-secondary-700"
                wire:model="term"
                wire:keydown.enter="performSearch"
            />
        </div>

        <div
            class="text-theme-secondary-900 dark:text-theme-secondary-600"
            x-on:click="showAdvanced = !showAdvanced"
        >
            <span x-show="!showAdvanced">@lang('actions.advanced_search')</span>
            <span x-show="showAdvanced">@lang('actions.hide_search')</span>
        </div>

        <button type="button" class="button-primary">@lang('actions.find_it')</button>
    </div>

    <div
        x-show="showAdvanced"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 transform"
        x-transition:enter-end="opacity-100 transform"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform"
        x-transition:leave-end="opacity-0 transform"
    >
        <div class="flex flex-wrap items-center py-8 border-t border-theme-secondary-300 dark:border-theme-secondary-800">
            <div class="flex flex-col pl-8 border-r border-theme-secondary-300 dark:border-theme-secondary-800 md:w-1/2 xl:flex-1">
                <div class="text-sm font-semibold">@lang('forms.search.type')</div>
                {{-- <x-ark-select :show-label="false" name="type" class="border-none" /> --}}
                <div class="flex items-center">
                    {{-- TODO: Enum of types and their values? --}}
                    <select class="bg-transparent pr-8 appearance-none font-medium text-theme-secondary-900 dark:text-theme-secondary-700">
                        <option value="">Multisignature Registration</option>
                    </select>

                    @svg('chevron-down', 'h-3 w-3 -ml-6 inline-block')
                </div>
            </div>

            <div class="flex flex-col pl-8 xl:border-r border-theme-secondary-300 dark:border-theme-secondary-800 md:w-1/2 xl:flex-1">
                <div class="text-sm font-semibold">@lang('forms.search.amount_range')</div>

                <div class="flex items-center space-x-2">
                    <input
                        type="text"
                        placeholder="0.00"
                        class="w-full dark:text-theme-secondary-700"
                        wire:model="amountRangeFrom"
                        wire:keydown.enter="performSearch"
                    />

                    <span>-</span>

                    <input
                        type="text"
                        placeholder="0.00"
                        class="w-full dark:text-theme-secondary-700"
                        wire:model="amountRangeTo"
                        wire:keydown.enter="performSearch"
                    />
                </div>
            </div>

            <div class="w-full border-t border-theme-secondary-300 dark:border-theme-secondary-800 my-8 xl:hidden"></div>

            <div class="flex flex-col pl-8 border-r border-theme-secondary-300 dark:border-theme-secondary-800 md:w-1/2 xl:flex-1">
                <div class="text-sm font-semibold">@lang('forms.search.fee_range')</div>

                <div class="flex items-center space-x-2">
                    <input
                        type="text"
                        placeholder="0.00"
                        class="w-full dark:text-theme-secondary-700"
                        wire:model="feeRangeFrom"
                        wire:keydown.enter="performSearch"
                    />

                    <span>-</span>

                    <input
                        type="text"
                        placeholder="0.00"
                        class="w-full dark:text-theme-secondary-700"
                        wire:model="feeRangeTo"
                        wire:keydown.enter="performSearch"
                    />
                </div>
            </div>

            <div class="flex flex-col px-8 md:w-1/2 xl:flex-1">
                <div class="text-sm font-semibold">@lang('forms.search.date_range')</div>

                <div class="">
                    <input
                        type="date"
                        class="bg-transparent -ml-7"
                        wire:model="dateFrom"
                        style="width: 49px;"
                    />

                    <span>-</span>

                    <input
                        type="date"
                        class="bg-transparent -ml-6"
                        wire:model="dateTo"
                        style="width: 49px;"
                    />
                </div>
            </div>
        </div>

        <div class="flex items-center p-8 space-x-8 border-t border-theme-secondary-300 dark:border-theme-secondary-800">
            <div class="flex flex-col flex-1 space-y-2">
                <div class="text-sm font-semibold">@lang('forms.search.smartbridge')</div>

                <input
                    type="text"
                    placeholder="@lang('forms.search.smartbridge_placeholder')"
                    class="w-full dark:text-theme-secondary-700"
                    wire:model="term"
                    wire:keydown.enter="performSearch"
                />
            </div>
        </div>
    </div>
</div>
