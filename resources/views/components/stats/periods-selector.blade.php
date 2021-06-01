@props([
    'selected',
    'options' => [],
])

<div {{ $attributes->only('class') }}>

    {{--mobile: input select--}}
    <label class="relative sm:hidden">
        <span class="flex absolute top-0 right-0 bottom-0 items-center transform translate-x-2 translate-y-px">
            <x-ark-icon name="chevron-down" size="2xs" />
        </span>
        <select
            {{ $attributes->wire('model') }}
            class="-ml-1 text-sm font-semibold bg-transparent appearance-none text-theme-secondary-700">
            @foreach($options as $val => $label)
                <option value="{{ $val }}">{{ $label }}</option>
            @endforeach
        </select>
    </label>

    {{--tablet: dropdown--}}
    <div class="hidden sm:block md:hidden">
        <x-ark-dropdown
            wrapper-class="relative p-2 mb-8 w-full rounded-xl border border-theme-primary-100 dark:border-theme-secondary-800"
            button-class="p-3 w-full font-semibold text-left text-theme-secondary-900 dark:text-theme-secondary-200"
            dropdown-classes="left-0 w-full z-20"
        >
            <x-slot name="button">
                <div class="flex items-center space-x-4">
                    <div>
                        <div x-show="dropdownOpen !== true">
                            <x-ark-icon name="menu" size="sm" />
                        </div>

                        <div x-show="dropdownOpen === true">
                            <x-ark-icon name="menu-show" size="sm" />
                        </div>
                    </div>

                    <div>@lang('forms.statistics.'.$selected)</div>
                </div>
            </x-slot>

            <div class="block justify-center items-center py-3 mt-1">
                @foreach($options as $val => $label)
                    <a
                        wire:click="$set('period', '{{ $val }}');"
                        class="dropdown-entry @if($selected === $val) dropdown-entry-selected @endif"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </x-ark-dropdown>
    </div>

    {{--desktop: buttons group--}}
    <div class="hidden md:inline-flex">
        <x-tabs.wrapper
            default-selected="{{ $selected }}"
            on-selected="function (value) {
                this.$wire.set('period', value);
            }"
        >
            @foreach($options as $val => $label)
                <x-tabs.tab :name="$val">
                    <span>{{ $label }}</span>
                </x-tabs.tab>
            @endforeach

            <x-slot name="right">
                <div class="w-8 h-auto"></div>
            </x-slot>
        </x-tabs.wrapper>
    </div>
</div>
