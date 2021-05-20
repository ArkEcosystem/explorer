<div class="h-20"></div>
<div x-data="{ open: false, openDropdown: null, selectedChild: null }" id="navbar" class="fixed z-20 w-full">
    <div
        x-show="openDropdown !== null || open"
        class="overflow-y-auto fixed inset-0 z-30 bg-theme-secondary-900 dark:bg-theme-secondary-800"
        :class="{
            'opacity-75 dark:opacity-50': openDropdown !== 'settings',
            'opacity-0': openDropdown === 'settings',
        }"
        x-cloak
        @click="openDropdown = null; open = false;"
    ></div>

    <nav class="relative z-30 bg-white shadow-header-smooth dark:shadow-header-smooth-dark dark:bg-theme-secondary-900">
        <div class="px-8 md:px-10 py-0.5">
            <div class="flex relative justify-between h-20">

                {{-- LOGO --}}
                <div class="flex flex-shrink-0 items-center">
                    <a class="flex items-center" href="{{ route('home') }}">
                        @if($logo ?? false)
                            {{ $logo }}
                        @else
                            <x-ark-icon name="ark-logo-red-square" size="xxl" />

                            <div class="hidden ml-6 text-lg lg:block"><span class="font-black text-theme-secondary-900">ARK</span> {{ $title }}</div>
                        @endif
                    </a>
                </div>

                <div class="flex justify-end">
                    <div class="flex flex-1 justify-end items-center sm:items-stretch sm:justify-between">
                        {{-- Desktop Navbar Items --}}
                        <div class="hidden items-center lg:ml-6 lg:flex">
                            @foreach ($navigation as $navItem)
                                @if(isset($navItem['children']))
                                    <a
                                        href="#"
                                        class="relative inline-flex justify-center items-center px-1 pt-1 font-semibold leading-5 border-b-2 border-transparent text-theme-secondary-700 hover:text-theme-secondary-800 hover:border-theme-secondary-300 focus:outline-none transition duration-150 ease-in-out h-full dark:text-theme-secondary-500 dark:hover:text-theme-secondary-400
                                            @if(!$loop->first) ml-8 @endif"
                                        @click="openDropdown = openDropdown === '{{ $navItem['label'] }}' ? null : '{{ $navItem['label'] }}'"
                                    >
                                        <span :class="{ 'text-theme-primary-600': openDropdown === '{{ $navItem['label'] }}' }">{{ $navItem['label'] }}</span>
                                        <span class="ml-2 transition duration-150 ease-in-out text-theme-primary-600" :class="{ 'rotate-180': openDropdown === '{{ $navItem['label'] }}' }"><x-ark-icon name="chevron-down" size="xs" /></span>
                                    </a>
                                    <div x-show="openDropdown === '{{ $navItem['label'] }}'" class="absolute top-0 right-0 z-30 pb-8 mt-24 bg-white rounded-b-lg" x-cloak>
                                        <div class="pb-8 mx-8 border-t border-theme-secondary-200"></div>
                                        <div class="flex">
                                            <div class="flex-shrink-0 w-56 border-r border-theme-secondary-300">
                                                @foreach ($navItem['children'] as $childNavItem)
                                                    <div @mouseenter="selectedChild = {{ json_encode($childNavItem) }}">
                                                        <x-ark-sidebar-link :route="$childNavItem['route']" :name="$childNavItem['label']" :params="$childNavItem['params'] ?? []"/>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="flex flex-col flex-shrink-0 pr-8 pl-8 w-128">
                                                <img class="w-full" :src="selectedChild ? selectedChild.image : '{{ $navItem['image'] }}'" />

                                                <template x-if="selectedChild">
                                                    <span x-text="selectedChild.label" class="mb-2 text-xl font-semibold text-theme-secondary-900"></span>
                                                    <span x-text="selectedChild.description"></span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a
                                        href="{{ route($navItem['route'], $navItem['params'] ?? []) }}"
                                        class="inline-flex items-center px-1 pt-1 font-semibold leading-5 border-b-2
                                            focus:outline-none transition duration-150 ease-in-out h-full
                                            -mb-1
                                            @if(optional(Route::current())->getName() === $navItem['route'])
                                                border-theme-primary-600 text-theme-secondary-900 dark:text-theme-secondary-400
                                            @else
                                                border-transparent text-theme-secondary-700 hover:text-theme-secondary-800 hover:border-theme-secondary-300 dark:text-theme-secondary-500 dark:hover:text-theme-secondary-400
                                            @endif
                                            @if(!$loop->first) ml-8 @endif"
                                        @click="openDropdown = null;"
                                    >
                                        {{ $navItem['label'] }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="flex inset-y-0 right-0 items-center pr-2 sm:static sm:inset-auto sm:ml-4 sm:pr-0">
                        {{-- Mobile Hamburger icon --}}
                        <div class="flex items-center lg:hidden">
                            <button @click="open = !open" class="inline-flex justify-center items-center rounded-md transition duration-150 ease-in-out text-theme-secondary-900 dark:text-theme-secondary-600">
                                <span :class="{'hidden': open, 'inline-flex': !open }">
                                    <x-ark-icon name="menu" size="sm" />
                                </span>

                                <span :class="{'hidden': !open, 'inline-flex': open }" x-cloak>
                                    <x-ark-icon name="menu-show" size="sm" />
                                </span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center ml-6 md:hidden">
                        <div class="pl-8 border-l border-theme-primary-100 text-theme-secondary-900 dark:text-theme-secondary-600 dark:border-theme-secondary-800">
                            <button
                                @click="$dispatch('mobile-search')"
                                class="inline-flex justify-center items-center py-2 rounded-md transition duration-150 ease-in-out text-theme-primary-300 dark:text-theme-secondary-600"
                            >
                                <span class="inline-flex"><x-ark-icon name="search" size="sm" /></span>
                            </button>
                        </div>
                    </div>

                    @if(Network::canBeExchanged())
                        <div class="hidden items-center ml-6 md:flex lg:ml-8">
                            <div class="pl-8 font-semibold border-l border-theme-primary-100 text-theme-secondary-900 dark:text-theme-secondary-600 dark:border-theme-secondary-800">
                                <livewire:price-ticker />
                            </div>
                        </div>
                    @endif

                    <livewire:navbar-settings />
                </div>
            </div>
        </div>

        {{-- Mobile dropdown --}}
        <div :class="{'block': open, 'hidden': !open}" class="border-t-2 lg:hidden border-theme-secondary-200 dark:border-theme-secondary-800">
            <div class="pt-2 pb-4 rounded-b-lg">
               @foreach ($navigation as $navItem)
                    @if(isset($navItem['children']))
                        <div class="flex w-full">
                            <div class="z-10 -mr-1 w-2"></div>
                            <a
                                href="#"
                                class="flex justify-between items-center py-3 px-8 w-full font-semibold border-l-2 border-transparent"
                                @click="openDropdown = openDropdown === '{{ $navItem['label'] }}' ? null : '{{ $navItem['label'] }}'"
                            >
                                <span :class="{ 'text-theme-primary-600': openDropdown === '{{ $navItem['label'] }}' }">{{ $navItem['label'] }}</span>
                                <span class="ml-2 transition duration-150 ease-in-out text-theme-primary-600" :class="{ 'rotate-180': openDropdown === '{{ $navItem['label'] }}' }"><x-ark-icon name="chevron-down" size="xs" /></span>
                            </a>
                        </div>
                        <div x-show="openDropdown === '{{ $navItem['label'] }}'" class="pl-8" x-cloak>
                            @foreach ($navItem['children'] as $childNavItem)
                                <div @mouseenter="selectedChild = {{ json_encode($childNavItem) }}">
                                    <x-ark-sidebar-link :route="$childNavItem['route']" :name="$childNavItem['label']" :params="$childNavItem['params'] ?? []" />
                                </div>
                            @endforeach


                        </div>
                    @else
                        <x-ark-navbar-link-mobile :route="$navItem['route']" :name="$navItem['label']" :params="$navItem['params'] ?? []" />
                    @endif
                @endforeach

                @if(Network::canBeExchanged())
                    <div class="flex px-8 py-3 mt-2 -mb-4 font-semibold bg-theme-secondary-100 text-theme-secondary-900 dark:text-theme-secondary-300 dark:bg-theme-secondary-800">
                        <livewire:price-ticker />
                    </div>
                @endif
            </div>
        </div>
    </nav>
</div>
