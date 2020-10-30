<div x-data="{ publicKeyModalVisible: false }" class="relative">
    <button type="button" @click="publicKeyModalVisible = !publicKeyModalVisible"
        class="flex items-center justify-center flex-1 w-16 px-3 rounded cursor-pointer bg-theme-secondary-800 hover:bg-theme-primary-600 transition-default lg:flex-none h-11">
        @svg('key', 'w-6 h-6')
    </button>

    <div @click.away="publicKeyModalVisible = false" x-show="publicKeyModalVisible" class="absolute left-0 z-10 mt-4 bg-white rounded-lg shadow-lg md:right-0 dark:bg-theme-secondary-900 w-128" x-cloak>
        <div class="flex flex-col p-10 space-y-2 leading-tight">
            <span class="text-sm font-semibold text-theme-secondary-400 dark:text-theme-secondary-700">@lang('pages.wallet.public_key.title')</span>
            <span class="flex font-semibold link">
                <span class="hidden lg:inline-block">
                    {{ $publicKey }}
                </span>

                <span class="lg:hidden">
                    <x-truncate-middle :value="$publicKey" :length="16" />
                </span>

                <x-ark-clipboard :value="$publicKey" class="flex items-center w-auto h-auto ml-2 text-theme-primary-300 dark:text-theme-secondary-600" no-styling />
            </span>
        </div>
    </div>
</div>
