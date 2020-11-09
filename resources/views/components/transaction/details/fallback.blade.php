<x-grid.sender :model="$transaction" />

<x-grid.timestamp :model="$transaction" />

<x-grid.block-id :model="$transaction" />

<x-grid.nonce :model="$transaction" />

@if ($transaction->isIpfs())
    <x-grid.ipfs-hash :model="$transaction" />
@endif