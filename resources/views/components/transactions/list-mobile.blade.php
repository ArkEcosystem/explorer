<div class="space-y-8 divide-y table-list-mobile">
    @foreach ($transactions as $transaction)
        <div class="space-x-10 table-list-mobile-row sm:space-x-8">
            <div class="space-y-6">
                <div>ID</div>
                <div>Timestamp</div>
                <div>Sender</div>
                <div>Recipient</div>
                <div>Amount</div>
                <div>Fee</div>
            </div>

            <div class="flex-1 space-y-6">
                <div><a href="{{ $transaction->url() }}" class="font-semibold link">{{ $transaction->id() }}</a></div>
                <div>{{ $transaction->timestamp() }}</div>
                <div><x-general.address address="{{ $transaction->sender() }}" /></div>
                <div><x-general.address address="{{ $transaction->recipient() ?? $transaction->sender() }}" /></div>
                <div>{{ $transaction->amount() }}</div>
                <div>{{ $transaction->fee() }}</div>
            </div>
        </div>
    @endforeach
</div>
