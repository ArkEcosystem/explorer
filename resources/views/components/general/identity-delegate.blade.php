<div class="flex items-center justify-between space-x-3">
    <div class="flex items-center">
        <a href="{{ route('wallet', $model->address()) }}" class="font-semibold link">
            {{ $model->username() }}
        </a>
        <span class="hidden ml-2 sm:inline md:hidden lg:inline text-theme-secondary-400">
            <x-truncate-middle :length="16">
                {{ $model->address() }}
            </x-truncate-middle>
        </span>
    </div>
</div>
