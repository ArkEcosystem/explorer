<th
    width="40"
    class="text-left cursor-pointer"
    @isset($onClick)
        wire:click="{{ $onClick }}"
    @endisset
>
    <div class="flex items-center">
        @lang($name)

        @isset($sortingDirection)
            <x-general.sorting-icon :sorting-direction="$sortingDirection" />
        @endisset
    </div>
</th>
