<div class="hidden table-container w-full md:block">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th class="hidden lg:table-cell">Timestamp</th>
                <th class="text-center hidden xl:table-cell">Type</th>
                <th><span class="pl-14">Sender</span></th>
                <th><span class="pl-14">Recipient</span></th>
                <th class="text-right">Amount</th>
                <th class="text-right hidden xl:table-cell">Fee</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td><x-ark-external-link :url="$transaction->id" text="" inline /></td>
                    <td class="hidden lg:table-cell">{{ $transaction->timestamp }}</td>
                    <td class="hidden xl:table-cell">
                        <div class="flex mx-auto items-center justify-center w-10 h-10 border-2 rounded-full text-theme-secondary-900 border-theme-secondary-900">
                            @svg('app-transactions.transfer', 'w-4 h-4')
                        </div>
                    </td>
                    <td><x-general.address :address="$transaction->sender" /></td>
                    <td><x-general.address :address="$transaction->recipient ?? $transaction->sender" /></td>
                    <td class="text-right">{{ $transaction->amount }}</td>
                    <td class="text-right hidden xl:table-cell">{{ $transaction->fee }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- {{ $transactions->links() }} --}}
</div>
