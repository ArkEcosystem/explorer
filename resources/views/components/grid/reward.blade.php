<x-grid.generic :title="trans('general.block.reward')" icon="app-reward">
    <x-currency :currency="Network::currency()">{{ $model->reward() }}</x-currency>
</x-grid.generic>
