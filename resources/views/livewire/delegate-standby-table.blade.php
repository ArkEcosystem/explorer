<div class="w-full">
    <x-loading.visible>
        <x-tables.desktop.skeleton.delegates.standby />
    </x-loading.visible>

    <x-loading.hidden>
        <x-tables.desktop.delegates.standby :delegates="$delegates" />
        <x-general.pagination :results="$delegates" class="mt-8" />
    </x-loading.hidden>
</div>
