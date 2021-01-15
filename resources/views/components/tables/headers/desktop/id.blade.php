<th
    width="40"
    class="text-left cursor-pointer"
    @isset($onClick)
        wire:click="{{ $onClick }}"
    @endisset
>
    @lang($name)
</th>
