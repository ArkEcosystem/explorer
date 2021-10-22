<div class="w-full">
    <x-loading.visible>
        <x-tables.desktop.skeleton.delegates.resigned />
    </x-loading.visible>

    <x-loading.hidden>
        @if (! $load)
            <x-tables.desktop.skeleton.delegates.resigned />
        @else
            <x-tables.desktop.delegates.resigned :delegates="$delegates" />
            <x-general.pagination :results="$delegates" class="mt-8" />
        @endif
    </x-loading.hidden>
</div>
