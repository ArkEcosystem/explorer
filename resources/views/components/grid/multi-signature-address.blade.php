<x-details.address
    :title="trans('general.transaction.multi_signature_address')"
    :transaction="$model"
    :model="$model->multiSignatureWallet()"
    icon="app.transactions-multi-signature"
    icon-size="sm"
    icon-class="ml-2 text-theme-secondary-500 dark:text-theme-secondary-700"
/>
