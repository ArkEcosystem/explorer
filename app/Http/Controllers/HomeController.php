<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\Cache\FeeCache;
use App\Services\Cache\NetworkCache;
use App\Services\Cache\PriceChartCache;
use Illuminate\View\View;

final class HomeController
{
    public function __invoke(NetworkCache $network, PriceChartCache $prices, FeeCache $fees): View
    {
        return view('app.home');
    }
}
