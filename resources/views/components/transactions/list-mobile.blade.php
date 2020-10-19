<div class="table-list-mobile divide-y space-y-8">
    @foreach ($transactions as $transaction)
        <div class="table-list-mobile-row space-x-10 sm:space-x-8">
            <div class="space-y-2">
                <div>ID</div>
                <div>Timestamp</div>
                <div>Sender</div>
                <div>Recipient</div>
                <div>Amount</div>
                <div>Fee</div>
            </div>

            <div class="flex-1 space-y-2">
                <div><a href="{{ $transaction->id }}" class="link font-semibold">{{ $transaction->id }}</a></div>
                <div>{{ $transaction->timestamp }}</div>
                <div><x-general.address address="{{ $transaction->sender }}" /></div>
                <div><x-general.address address="{{ $transaction->recipient ?? $transaction->sender }}" /></div>
                <div>{{ $transaction->amount }}</div>
                <div>{{ $transaction->fee }}</div>
            </div>
        </div>
    @endforeach
</div>
