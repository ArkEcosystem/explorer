<div class="hidden table-container md:block">
    <table>
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="hidden lg:table-cell">Timestamp</th>
                <th class="hidden text-center xl:table-cell">Type</th>
                <th><span class="pl-14">Sender</span></th>
                <th><span class="pl-14">Recipient</span></th>
                <th class="text-right">Amount</th>
                <th class="hidden text-right xl:table-cell">Fee</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
                <tr>
                    <td>
                        <div class="flex items-center">
                            <a href="{{ $transaction->id() }}" class="mx-auto link">
                                @svg('link', 'h-4 w-4')
                            </a>
                        </div>
                    </td>
                    <td class="hidden lg:table-cell">{{ $transaction->timestamp() }}</td>
                    <td class="hidden xl:table-cell">
                        <div class="flex items-center justify-center w-10 h-10 mx-auto border-2 rounded-full text-theme-secondary-900 border-theme-secondary-900">
                            @svg('app-transactions.transfer', 'w-4 h-4')
                        </div>
                    </td>
                    <td><x-general.address :address="$transaction->sender()" /></td>
                    <td><x-general.address :address="$transaction->recipient() ?? $transaction->sender()" /></td>
                    <td class="text-right">{{ $transaction->amount() }}</td>
                    <td class="hidden text-right xl:table-cell">{{ $transaction->fee() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
