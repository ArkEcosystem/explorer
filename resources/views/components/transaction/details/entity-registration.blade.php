<x-grid.sender :model="$transaction" />

<x-grid.fee :model="$transaction" />

<x-grid.block-id :model="$transaction" />

<x-grid.timestamp :model="$transaction" />

<x-grid.nonce :model="$transaction" responsive-border />

<x-grid.confirmations :model="$transaction" without-border />
