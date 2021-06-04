<div class="flex justify-between items-center">
    <div class="flex items-center space-x-3 max-w-full">
        <a href="{{ route('wallet', $model->address()) }}" class="font-semibold link">
            {{ $model->username() }}
        </a>
        <span class="hidden min-w-0 sm:inline md:hidden lg:inline font-semibold text-theme-secondary-500">
            <x-truncate-dynamic>{{ $model->address() }}</x-truncate-dynamic>
        </span>
    </div>
</div>
