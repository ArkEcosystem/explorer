<div x-data="{ visible: false }">
    <button type="button" @click="visible = !visible"
        class="relative flex items-center justify-center flex-1 w-16 px-3 rounded cursor-pointer bg-theme-secondary-800 hover:bg-theme-primary-600 transition-default lg:flex-none h-11">
        @svg('key', 'w-6 h-6')
    </button>

    <div x-show="visible" class="absolute z-10 mt-2 origin-top-left bg-white rounded-md shadow-lg w-128" x-cloak>
        {{--<x-ark-modal class="w-full mx-6" width-class="max-w-sm"
            alpine-close="visible = false" title-class="header-2">--}}

            {{--@slot('description')--}}
            <div class="flex flex-col space-x-2 leading-tight">
                <span>@lang('pages.wallet.public_key.title')</span>
                <span class="flex text-theme-secondary-400 dark:text-theme-secondary-200 link">
                    <span class="hidden lg:inline-block">
                        {{ $publicKey }}
                    </span>

                    <span class="lg:hidden">
                        <x-truncate-middle :value="$publicKey" :length="16" />
                    </span>

                    <x-ark-clipboard :value="$publicKey"
                        class="flex items-center w-auto h-auto ml-2 text-theme-secondary-600" no-styling />
                </span>
            </div>
            {{--@endslot--}}
        {{--</x-ark-modal>--}}
    </div>
</div>
