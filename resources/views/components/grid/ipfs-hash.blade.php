<x-grid.generic :title="trans('general.transaction.ipfs-hash')" icon="app-transactions.ipfs">
    <span class="flex items-center">
        <a href="https://cloudflare-ipfs.com/ipfs/{{ $model->ipfsHash() }}" class="font-semibold sm:hidden md:inline lg:hidden link">
            <x-truncate-middle :value="$model->ipfsHash()" :length="10" />
        </a>

        <a href="https://cloudflare-ipfs.com/ipfs/{{ $model->ipfsHash() }}" class="hidden font-semibold sm:inline md:hidden lg:inline link">
            <x-truncate-middle :value="$model->ipfsHash()" :length="30" />
        </a>

        <a href="https://cloudflare-ipfs.com/ipfs/{{ $model->ipfsHash() }}" class="link ml-2">
            @svg('link', 'h-4 w-4 link')
        </a>
    </span>
</x-grid.generic>