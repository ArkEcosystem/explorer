<x-general.identity :model="$model" :without-truncate="$withoutTruncate ?? false" :dynamic-truncate="$dynamicTruncate ?? false">
    @if ($model->username())
        <x-slot name="suffix">
            <span class="hidden ml-1 lg:flex">
                <x-truncate-middle>{{ $model->address() }}</x-truncate-middle>
            </span>
        </x-slot>
    @endif
</x-general.identity>
