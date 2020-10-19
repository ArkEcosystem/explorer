<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\Transaction;
use App\ViewModels\ViewModelFactory;
use Livewire\Component;
use Livewire\WithPagination;

final class TransactionTable extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.transaction-table', [
            'transactions' => [
                (object) [
                    'id'        => '12345…57394',
                    'timestamp' => '17 Feb. 2020 22:03:13',
                    'type'      => 'tx',
                    'sender'    => 'AS8qe…Md7Uv',
                    'recipient' => 'AaYKk…KXMCA',
                    'amount'    => '1,501.30463002 ARK',
                    'fee'       => '0.00816 ARK',
                ],
                (object) [
                    'id'        => '12345…57394',
                    'timestamp' => '17 Feb. 2020 22:03:13',
                    'type'      => 'tx',
                    'sender'    => 'AS8qe…Md7Uv',
                    'recipient' => 'AaYKk…KXMCA',
                    'amount'    => '1,501.30463002 ARK',
                    'fee'       => '0.00816 ARK',
                ],
                (object) [
                    'id'        => '12345…57394',
                    'timestamp' => '17 Feb. 2020 22:03:13',
                    'type'      => 'tx',
                    'sender'    => 'AS8qe…Md7Uv',
                    'recipient' => 'AaYKk…KXMCA',
                    'amount'    => '1,501.30463002 ARK',
                    'fee'       => '0.00816 ARK',
                ],
                (object) [
                    'id'        => '12345…57394',
                    'timestamp' => '17 Feb. 2020 22:03:13',
                    'type'      => 'tx',
                    'sender'    => 'AS8qe…Md7Uv',
                    'recipient' => 'AaYKk…KXMCA',
                    'amount'    => '1,501.30463002 ARK',
                    'fee'       => '0.00816 ARK',
                ],
                (object) [
                    'id'        => '12345…57394',
                    'timestamp' => '17 Feb. 2020 22:03:13',
                    'type'      => 'tx',
                    'sender'    => 'AS8qe…Md7Uv',
                    'recipient' => 'AaYKk…KXMCA',
                    'amount'    => '1,501.30463002 ARK',
                    'fee'       => '0.00816 ARK',
                ],
                (object) [
                    'id'        => '12345…57394',
                    'timestamp' => '17 Feb. 2020 22:03:13',
                    'type'      => 'tx',
                    'sender'    => 'AS8qe…Md7Uv',
                    'recipient' => 'AaYKk…KXMCA',
                    'amount'    => '1,501.30463002 ARK',
                    'fee'       => '0.00816 ARK',
                ],
                (object) [
                    'id'        => '12345…57394',
                    'timestamp' => '17 Feb. 2020 22:03:13',
                    'type'      => 'tx',
                    'sender'    => 'AS8qe…Md7Uv',
                    'recipient' => 'AaYKk…KXMCA',
                    'amount'    => '1,501.30463002 ARK',
                    'fee'       => '0.00816 ARK',
                ],
            ],
            // 'transactions' => ViewModelFactory::paginate(Transaction::latestByTimestamp()->paginate()),
        ]);
    }
}
