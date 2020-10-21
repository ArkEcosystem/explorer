<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

final class ShowWalletsByBalanceController
{
    public function __invoke(Request $request): View
    {
        return view('app.wallets');
    }
}
