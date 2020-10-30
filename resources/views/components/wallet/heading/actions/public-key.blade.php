<div x-data="{ publicKeyModalVisible: false }" class="lg:relative flex-1">
    <button type="button" @click="publicKeyModalVisible = !publicKeyModalVisible"
        class="flex items-center justify-center w-full px-3 rounded cursor-pointer lg:w-auto bg-theme-secondary-800 hover:bg-theme-primary-600 transition-default lg:flex-none h-11">
        @svg('key', 'w-6 h-6')
    </button>

    <div @click.away="publicKeyModalVisible = false" x-show="publicKeyModalVisible" class="absolute right-0 left-0 lg:left-auto mx-8 lg:mx-0 z-10 w-auto mt-4 bg-white rounded-lg shadow-lg dark:bg-theme-secondary-900" x-cloak>
        <div class="flex flex-col p-10 space-y-2 leading-tight">
            <span class="text-sm font-semibold text-theme-secondary-400 dark:text-theme-secondary-700">@lang('pages.wallet.public_key.title')</span>
            <span class="flex font-semibold link">
                <span class="hidden md:inline-block">
                    {{ $publicKey }}
                </span>

                <span class="md:hidden">
                    <x-truncate-middle :value="$publicKey" :length="16" />
                </span>

                <x-ark-clipboard :value="$publicKey" class="flex items-center w-auto h-auto ml-2 text-theme-primary-300 dark:text-theme-secondary-600" no-styling />
            </span>
        </div>
    </div>
</div>
