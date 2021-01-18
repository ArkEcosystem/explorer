<th
    width="40"
    class="text-left cursor-pointer"
    {{ $attributes->except(['class', 'width']) }}
>
    <div class="flex flex-row items-center">
        @lang($name)

        @if($attributes->get('with-ordering'))
            <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-2 w-2 h-2" />
        @else
            <x-ark-icon name="chevron-down" size="xs" class="ml-2 w-2 h-2" />
        @endif
    </div>
</th>
