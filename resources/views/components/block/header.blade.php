<div class="dark:bg-black">
    <div class="flex-col py-16 content-container space-y-6">
        <x-general.search.header-slim :title="trans('pages.block.title')" />

        <x-general.entity-header
            title="Block ID"
            value="5e665af8f9805b0a8171b5badf6289ddff96e110e512725132c6f4e3dffea94e"
        >
            <x-slot name="logo">@svg('app-block-id', 'w-5 h-5')</x-slot>

            <x-slot name="extra">
                <div class="flex items-center space-x-2 text-theme-secondary-400 mt-6 md:mt-0">
                    <div class="flex bg-theme-secondary-800 cursor-pointer px-3 h-full rounded hover:bg-theme-secondary-700 transition-default flex-1 md:flex-none items-center justify-center">
                        @svg('chevron-left', 'w-6 h-6')
                    </div>

                    <div class="flex bg-theme-secondary-800 cursor-pointer px-3 h-full rounded hover:bg-theme-secondary-700 transition-default flex-1 md:flex-none items-center justify-center">
                        @svg('chevron-right', 'w-6 h-6')
                    </div>
                </div>
            </x-slot>

            <x-slot name="bottom">
                <div class="grid gap-8 grid-cols-1 md:grid-cols-2 xl:grid-cols-4">
                    <x-general.entity-header-item title="Generated By" avatar="delegate_name" text="cams_yellow_jacket" url="asd" />
                    <x-general.entity-header-item title="Transaction Volumn" icon="app-votes" text="475.133 ARK" />
                    <x-general.entity-header-item title="Transactions" icon="exchange" text="3" />
                    <x-general.entity-header-item title="Total Rewards" icon="app-reward" text="2.073541 ARK" />
                </div>
            </x-slot>
        </x-general.entity-header>
    </div>
</div>
