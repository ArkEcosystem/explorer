<x-loading.visible>
    <x-tables.desktop.skeleton.transactions :compact="Settings::usesCompactTables()" />

    <x-tables.mobile.skeleton.transactions compact="false" />
</x-loading.visible>

<x-loading.hidden>
    {{ $slot }}
</x-loading.hidden>
