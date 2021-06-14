<div x-data="{ publicKeyModalVisible: false }" class="flex-1 w-full mt-4 sm:mt-0 sm:w-auto">
    <button type="button" @click="publicKeyModalVisible = !publicKeyModalVisible"
        class="flex items-center justify-center w-full px-3 rounded cursor-pointer h-11 lg:flex-none lg:w-16 bg-theme-secondary-800 transition-default dark:text-theme-secondary-600 dark:hover:text-theme-secondary-200 hover:bg-theme-primary-600">
        <x-ark-icon name="key" />
    </button>

    <div @click.away="publicKeyModalVisible = false" x-show="publicKeyModalVisible" class="absolute left-0 right-0 w-auto mx-8 mt-4 bg-white shadow-lg rounded-xl lg:left-auto lg:mx-0 lg:mt-1 lg:mr-32 z-15 dark:shadow-lg-dark dark:bg-theme-secondary-900" x-cloak>
        <div class="flex flex-col p-6 space-y-2 leading-tight">
            <span class="text-sm font-semibold text-theme-secondary-400 dark:text-theme-secondary-700">@lang('pages.wallet.public_key.title')</span>
            <span class="flex font-semibold link">
                <span class="inline-block truncate">
                    {{ $publicKey }}
                </span>

                <x-clipboard :value="$publicKey" />
            </span>
        </div>
    </div>
</div>
