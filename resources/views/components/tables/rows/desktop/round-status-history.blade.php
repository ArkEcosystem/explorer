<div class="flex flex-row items-center space-x-3">
    @foreach($model->performance() as $performed)
        @if($performed)
            <span class="text-theme-success-500">
                <x-ark-icon name="app-status-done" size="{{ $compact ? 'sm' : 'lg' }}" />
            </span>
        @else
            <span class="text-theme-danger-500">
                <x-ark-icon name="app-status-undone" size="{{ $compact ? 'sm' : 'lg' }}" />
            </span>
        @endif
    @endforeach
</div>
