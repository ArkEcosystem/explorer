<x-grid.generic :title="trans('general.transaction.ipfs-hash')" icon="app-transactions.ipfs">
    <span class="flex items-center">
        <a href="https://cloudflare-ipfs.com/ipfs/{{ $model->ipfs() }}" class="font-semibold sm:hidden md:inline lg:hidden link">
            <x-truncate-middle :value="$model->ipfs()" :length="10" />
        </a>

        <a href="https://cloudflare-ipfs.com/ipfs/{{ $model->ipfs() }}" class="hidden font-semibold sm:inline md:hidden lg:inline link">
            <x-truncate-middle :value="$model->ipfs()" :length="30" />
        </a>

        <x-clipboard :value="$model->ipfs()" />
    </span>
</x-grid.generic>