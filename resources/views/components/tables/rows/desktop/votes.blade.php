<div class="flex justify-end">
    <span>{{ App\Services\NumberFormatter::number($model->votes()) }} {{ Network::currency() }}</span>
    <span class="vote-percentage">
        <x-percentage>{{ $model->votesPercentage() }}</x-percentage>
    </span>
</div>
