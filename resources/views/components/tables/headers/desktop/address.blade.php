@php($withOrdering = $attributes->get('with-ordering'))

<th
    class="text-left @if($withOrdering) cursor-pointer @endif"
    {{ $attributes->except(['class']) }}
>
<div class="flex flex-row items-center">
    @lang($name)

    @if($withOrdering)
        <x-ark-icon name="{{ $this->renderDirectionIcon($name) }}" size="xs" class="ml-2 w-2 h-2" />
    @endif
</th>
