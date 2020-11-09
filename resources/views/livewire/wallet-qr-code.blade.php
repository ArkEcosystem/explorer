<div x-data="{ visible: {{ $isOpen ? 'true' : 'false' }}, options: false }" x-cloak>
    <div x-show="visible">
        <x-ark-modal class="w-full" width-class="max-w-md" wire-close="$emit('toggleQrCode')" alpine-close="visible = false" title-class="header-2">
            @slot('title')
                @lang('pages.wallet.qrcode.title')
            @endslot

            @slot('description')
                <div class="space-y-8">
                    <div class="mt-4 text-theme-secondary-700">@lang('pages.wallet.qrcode.description')</div>

                    <button x-show="! options" class="w-full button-secondary" @click="options = true">
                        @lang('pages.wallet.qrcode.specify_amount')
                    </button>

                    <x-wallet.qr-address :model="$wallet" />

                    <div x-show="options" class="space-y-8">
                        <x-ark-input
                            :label="trans('pages.wallet.amount')"
                            type="number"
                            id="amount"
                            name="amount"
                            :errors="$errors"
                            required
                            autofocus
                        />

                        <x-ark-input
                            class="mt-5"
                            type="text"
                            id="smartbridge"
                            name="smartbridge"
                            :errors="$errors"
                        >
                            <x-slot name="label">
                                <div class="flex space-x-1">
                                    <span>@lang('pages.wallet.smartbridge')</span>

                                    <span class="text-theme-secondary-500">@lang('general.optional')</span>
                                </div>
                            </x-slot>
                        </x-ark-input>
                    </div>

                    <div>
                        <div class="modal-qr-code">
                            {!! $this->code !!}
                        </div>

                        <div x-show="options" class="text-theme-secondary-700 mt-4">
                            <div class="text-center">
                                @lang('pages.wallet.qrcode.automatic_notice')
                            </div>

                            <div class="flex items-center space-x-3 mt-6">
                                <div class="flex-1 h-1px border-t border-theme-secondary-300"></div>
                                <div class="text-sm font-semibold">@lang('general.or')</div>
                                <div class="flex-1 h-1px border-t border-theme-secondary-300"></div>
                            </div>

                            <a href="{{ $this->walletUri }}" class="w-full button-secondary mt-2">
                                @lang('pages.wallet.qrcode.send_from_wallet')
                            </a>
                        </div>
                    </div>
                </div>
            @endslot
        </x-ark-modal>
    </div>
</div>
