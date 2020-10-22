<div id="block-list" class="w-full">
    <x-blocks.table-desktop :blocks="$blocks" />

    <x-blocks.list-mobile :blocks="$blocks" />

    <x-general.pagination :results="$blocks" class="mt-8" />
</div>
