<div wire:poll.60s class="flex overflow-x-auto gap-5 w-full md:overflow-x-hidden md:grid md:grid-cols-2 md:grid-rows-2 xl:grid-cols-4 xl:grid-rows-1">
    <x-stats.highlight icon="app.stats-total-supply" :title="trans('pages.statistics.highlights.total-supply')" :value="$totalSupply" />
    <x-stats.highlight icon="app.stats-voting" :title="trans('pages.statistics.highlights.voting', ['percent' => $votingPercent])" :value="$votingValue" />
    <x-stats.highlight icon="app.stats-delegates" :title="trans('pages.statistics.highlights.registered-delegates')" :value="$delegates" />
    <x-stats.highlight icon="app.stats-wallets" :title="trans('pages.statistics.highlights.wallets')" :value="$wallets" />
</div>
