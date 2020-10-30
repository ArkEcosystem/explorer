<div x-data="{ visible: false }">
    <button type="button" @click="visible = !visible"
        class="relative flex items-center justify-center flex-1 w-16 px-3 rounded cursor-pointer bg-theme-secondary-800 hover:bg-theme-primary-600 transition-default lg:flex-none h-11">
        @svg('key', 'w-6 h-6')
    </button>

    <div x-show="visible" class="absolute right-0 bg-white rounded-lg shadow-lg z-10 w-128 mt-4" x-cloak>
        <div class="flex flex-col leading-tight p-8 space-y-2">
            <span class="font-semibold text-theme-secondary-400 text-sm">@lang('pages.wallet.public_key.title')</span>
            <span class="flex text-theme-secondary-400 dark:text-theme-secondary-200 link font-semibold">
                <span class="hidden lg:inline-block">
                    {{ $publicKey }}
                </span>

                <span class="lg:hidden">
                    <x-truncate-middle :value="$publicKey" :length="16" />
                </span>

                <x-ark-clipboard :value="$publicKey" class="flex items-center w-auto h-auto ml-2 text-theme-primary-300" no-styling />
            </span>
        </div>
    </div>
</div>
