<x-grid.sender :model="$transaction" />

<x-grid.recipient-count :model="$transaction" />

<x-grid.block-id :model="$transaction" />

<x-grid.timestamp :model="$transaction" />

<x-grid.vendor-field :model="$transaction" responsive-border />

<x-grid.nonce :model="$transaction" without-border />
