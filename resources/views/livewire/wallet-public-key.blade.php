<div x-data="{ visible: {{ $isOpen ? 'true' : 'false' }}, options: false }" x-cloak>
    <div x-show="visible">
        <x-ark-modal class="w-full mx-6" width-class="max-w-sm" wire-close="$emit('togglePublicKey')"
            alpine-close="visible = false" title-class="header-2">

            @slot('description')
                <span>@lang('pages.wallet.public_key.title')</span>

                <div class="flex items-center space-x-2 leading-tight">
                    <span class="flex text-theme-secondary-400 dark:text-theme-secondary-200 link">
                        <span class="hidden lg:inline-block">
                            {{ $publicKey }}
                        </span>

                        <span class="lg:hidden">
                            <x-truncate-middle :value="$publicKey" :length="16" />
                        </span>

                        <x-ark-clipboard :value="$publicKey" class="flex items-center w-auto h-auto ml-2 text-theme-secondary-600" no-styling />
                    </span>
                </div>
            @endslot
        </x-ark-modal>
    </div>
</div>