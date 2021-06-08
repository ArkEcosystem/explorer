<?php

declare(strict_types=1);

use App\Http\Livewire\Stats\Chart;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use function Tests\configureExplorerDatabase;

beforeEach(function (): void {
    configureExplorerDatabase();

    Carbon::setTestNow('2020-01-01 00:00:00');
});

it('should render the component', function () {
    Config::set('explorer.networks.development.canBeExchanged', true);
    Config::set('explorer.networks.development.currency', 'ARK');

    Http::fake([
        'cryptocompare.com/data/pricemultifull*' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/pricemultifull.json')), true), 200),
        'cryptocompare.com/data/price*'          => Http::response(['USD' => 0.2907, 'BTC' => 0.00002907], 200),
        'cryptocompare.com/data/histoday*'       => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/historical.json')), true), 200),
        'cryptocompare.com/data/histohour*'      => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/histohour.json')), true), 200),
    ]);

    Artisan::call('explorer:cache-prices');

    Livewire::test(Chart::class)
        ->set('period', 'day')
        ->assertSee(trans('pages.statistics.chart.price'))
        ->assertSee('0.00002907 BTC')
        ->assertSee('$0.29')
        ->assertSee('13.70%')
        ->assertSee(trans('pages.statistics.chart.market-cap'))
        ->assertSee('$254,260,570.60')
        ->assertSee(trans('pages.statistics.chart.min-price'))
        ->assertSee('1.275 BTC')
        ->assertSee(trans('pages.statistics.chart.max-price'))
        ->assertSee('2.469 BTC')
        ->assertSee('[1.898]');
});

it('should not render the component', function () {
    Config::set('explorer.networks.development.canBeExchanged', false);
    Config::set('explorer.networks.development.currency', 'ARK');

    Http::fake([
        'cryptocompare.com/data/pricemultifull*' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/pricemultifull.json')), true), 200),
        'cryptocompare.com/data/price*'          => Http::response(['USD' => 0.2907, 'BTC' => 0.00002907], 200),
        'cryptocompare.com/data/histoday*'       => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/historical.json')), true), 200),
        'cryptocompare.com/data/histohour*'      => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/histohour.json')), true), 200),
    ]);

    Artisan::call('explorer:cache-prices');

    Livewire::test(Chart::class)
        ->set('period', 'day')
        ->assertDontSee(trans('pages.statistics.chart.price'))
        ->assertDontSee('0.00002907 BTC')
        ->assertDontSee('$0.29')
        ->assertDontSee('13.70%')
        ->assertDontSee(trans('pages.statistics.chart.market-cap'))
        ->assertDontSee('$254,260,570.60')
        ->assertDontSee(trans('pages.statistics.chart.min-price'))
        ->assertDontSee('1.275 BTC')
        ->assertDontSee(trans('pages.statistics.chart.max-price'))
        ->assertDontSee('2.469 BTC')
        ->assertDontSee('[0.1431,0.1398,0.1399,0.1456,0.1455,0.1457,0.1524,0.1462,0.1429,0.1381,0.1438,0.1407,0.14,0.1392,0.142,0.1486,0.1452,0.1556,0.16,0.1557,0.1523,0.1578,0.1646,0.1545,0.1635,0.1577,0.1562,0.1571,0.1628,0.1576,0.16,0.16,0.1669,0.1743,0.1764,0.1975,0.1967,0.2087,0.2147,0.2004,0.2188,0.2956,0.2755,0.2724,0.2732,0.284,0.2732,0.2425,0.2351,0.2484,0.2248,0.2293,0.2263,0.2265,0.2449,0.2258,0.2031,0.1907,0.1966,0.1947,0.1852,0.1936,0.2092,0.2173,0.216,0.2282,0.2328,0.2158,0.1819,0.1881,0.1881,0.1846,0.0916,0.1062,0.1109,0.1149,0.1065,0.125,0.1328,0.168,0.1595,0.1624,0.1451,0.1543,0.1625,0.1595,0.1629,0.1513,0.1446,0.1366,0.1482,0.1584,0.1558,0.1567,0.1604,0.1621,0.1598,0.1691,0.1637,0.1694,0.167,0.1538,0.1528,0.1529,0.1526,0.1989,0.182,0.1804,0.1735,0.1791,0.1737,0.1665,0.1604,0.1652,0.1672,0.173,0.1878,0.1865,0.184,0.1816,0.1868,0.1897,0.195,0.1996,0.1949,0.1922,0.1933,0.1894,0.1981,0.2066,0.2096,0.1889,0.1836,0.188,0.1905,0.1957,0.1796,0.1959,0.2084,0.2074,0.2069,0.2131,0.2056,0.2247,0.2123,0.2144,0.2274,0.2225,0.2161,0.2161,0.2158,0.2214,0.2182,0.2378,0.2333,0.2338,0.2333,0.2324,0.2389,0.2345,0.2377,0.2361,0.2405,0.2349,0.2507,0.251,0.2449,0.262,0.2763,0.285,0.3004,0.2834,0.2792,0.2823,0.3029,0.2994,0.32,0.3245,0.2969,0.33,0.2822,0.2808,0.2882,0.2601,0.2684,0.2559,0.2597,0.254,0.2809,0.2757,0.2882,0.2874,0.2975,0.3347,0.3294,0.2954,0.33,0.3183,0.3566,0.3368,0.3942,0.4054,0.4529,0.4412,0.4583,0.4607,0.4433,0.4236,0.4231,0.3735,0.403,0.4181,0.4522,0.4282,0.4249,0.4995,0.5938,0.5503,0.5226,0.5128,0.5081,0.5246,0.511,0.5047,0.4796,0.4858,0.4868,0.5191,0.5057,0.5284,0.5467,0.5224,0.479,0.5048,0.4779,0.5056,0.4978,0.533,0.4788,0.4914,0.4467,0.4554,0.4689,0.4725,0.4545,0.4434,0.4074,0.3245,0.3406,0.3135,0.32,0.3147,0.311,0.3452,0.3542,0.3511,0.3994,0.4082,0.3941,0.3547,0.3426,0.3566,0.3504,0.3617,0.3443,0.306,0.2998,0.2775,0.2969,0.3011,0.3025,0.3031,0.2952,0.3014,0.3045,0.2871,0.2735,0.2771,0.2784,0.2806,0.2686,0.2663,0.2789,0.3255,0.2987,0.3266,0.3154,0.3105,0.3014,0.2956,0.2867,0.2991,0.2946,0.2927,0.2704,0.2781]');
});

it('should filter by year', function () {
    Config::set('explorer.networks.development.canBeExchanged', true);
    Config::set('explorer.networks.development.currency', 'ARK');

    Http::fake([
        'cryptocompare.com/data/pricemultifull*' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/pricemultifull.json')), true), 200),
        'cryptocompare.com/data/price*'          => Http::response(['USD' => 0.2907, 'BTC' => 0.00002907], 200),
        'cryptocompare.com/data/histoday*'       => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/historical.json')), true), 200),
        'cryptocompare.com/data/histohour*'      => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/histohour.json')), true), 200),
    ]);

    Artisan::call('explorer:cache-prices');

    Livewire::test(Chart::class)
        ->set('period', 'year')
        ->assertSee(trans('pages.statistics.chart.price'))
        ->assertSee('0.00002907 BTC')
        ->assertSee('$0.29')
        ->assertSee('13.70%')
        ->assertSee(trans('pages.statistics.chart.market-cap'))
        ->assertSee('$254,260,570.60')
        ->assertSee(trans('pages.statistics.chart.min-price'))
        ->assertSee('1.275 BTC')
        ->assertSee(trans('pages.statistics.chart.max-price'))
        ->assertSee('2.469 BTC')
        ->assertSee('[0.03424,0.05805,0.0659,0.08981,0.0747,0.05936,0.068,0.06824,0.0602,0.06607,0.0625,0.05651,0.05737,0.05265,0.06036,0.07239,0.07024,0.07427,0.07767,0.07896,0.08689,0.09701,0.1294,0.1395,0.2469,0.2815,0.2507,0.2171,0.2601,0.236,0.2474,0.1985,0.1901,0.1997,0.1809,0.1673,0.1701,0.202,0.201,0.192,0.1889,0.2169,0.2304,0.2245,0.2443,0.255,0.2364,0.2463,0.218,0.2225,0.2225,0.2022,0.2247,0.2228,0.2114,0.179,0.1819,0.205,0.227,0.2087,0.2351,0.2386,0.2613,0.3206,0.2462,0.2775,0.212,0.2375,0.2333,0.2261,0.258,0.3016,0.3951,0.4353,0.5048,0.7036,0.804,0.9735,0.9516,1.05,0.8991,0.892,0.7349,0.904,0.7402,0.7073,0.7884,0.823,0.7349,0.7578,0.7575,0.702,0.7624,0.8012,0.7097,0.6812,0.6086,0.6384,0.6444,0.6112,0.5455,0.522,0.5415,0.5196,0.5941,0.7453,0.6985,0.5958,0.6358,0.5653,0.3992,0.3726,0.4398,0.459,0.4189,0.351,0.3292,0.4246,0.4666,0.4399,0.5669,0.531,0.668,0.6197,0.5864,0.5049,0.4793,0.4843,0.4353,0.4855,0.4866,0.5017,0.5999,0.5757,0.6612,0.7136,0.892,0.9383,0.8961,0.8279,0.8238,0.9171,0.858,0.9365,0.8649,1.679,1.728,1.562,1.298,1.56,1.593,1.657,1.81,1.753,1.63,1.579,1.576,1.717,1.979,2.617,2.574,2.38,2.4,2.537,2.358,2.561,2.243,2.5,2.612,2.643,2.566,2.813,2.96,3.716,3.685,3.541,3.538,3.944,3.577,3.301,3.698,3.239,3.117,2.718,2.809,3.156,3.004,3.165,2.945,3.201,2.959,2.757,2.992,2.898,2.793,2.791,2.493,2.745,2.592,2.528,2.212,2.384,2.595,2.833,2.662,2.629,2.836,2.862,2.767,2.817,2.824,2.871,2.775,2.564,2.637,2.53,2.86,2.587,2.526,2.519,2.432,2.436,2.422,2.443,2.097,2.048,2.496,2.322,2.363,2.54,2.533,2.915,3.236,2.876,2.883,2.57,2.911,3.188,3.186,3.117,2.965,3.2,3.147,3.135,3.097,3.112,2.997,3.061,3.176,3.505,3.776,3.427,2.924,3.069,3.405,3.645,4.051,4.211,4.575,4.184,3.576,3.928,3.755,3.434,3.743,4.285,4.415,4.501,4.267,4.985,5.91,6.815,6.405,7.493,7.886,5.771,6.585,6.288,7.068,7.861,7.357,6.897,7.867,6.474,6.99,7.563,7.842,7.542,7.027,6.814,7.803,8.022,7.915,9.324,10.29,8.234,8.894,8.972,8.032,7.785,5.566,6.2,6.295,6.534,7.124,5.939,5.414,6.017,6.78,7.236,6.772,6.635,6.568,6.599,5.457,5.664,4.803,4.607,5.024,4.193,3.179,3.76,3.513,3.787,4.197,4.041,3.756,4.055,4.081,4.47,4.908,4.852,4.987,4.533,4.651,4.111,4.075,3.728,3.91,3.607,3.686,3.774,3.773,3.584,3.682,4.02,4.434,4.181,4.005,3.735,3.483,3.189,3.207,3.071,3.531,3.218,3.358,2.831,2.868,2.832,2.509,2.42,2.75,2.849,2.752]');
});

it('should render min max price and percentage equals to zero', function () {
    Config::set('explorer.networks.development.canBeExchanged', true);
    Config::set('explorer.networks.development.currency', 'ARK');

    Http::fake([
        'cryptocompare.com/data/pricemultifull*' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/pricemultifull.json')), true), 200),
        'cryptocompare.com/data/price*'          => Http::response(['USD' => 0.2907, 'BTC' => 0.00002907], 200),
        'cryptocompare.com/data/histoday*'       => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/historical.json')), true), 200),
        'cryptocompare.com/data/histohour*'      => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/cryptocompare/histohour-zero.json')), true), 200),
    ]);

    Artisan::call('explorer:cache-prices');

    Livewire::test(Chart::class)
        ->set('period', 'year')
        ->assertSee(trans('pages.statistics.chart.price'))
        ->assertSee('0.00002907 BTC')
        ->assertSee('$0.29')
        ->assertSee('0.00%')
        ->assertSee(trans('pages.statistics.chart.market-cap'))
        ->assertSee('$254,260,570.60')
        ->assertSee(trans('pages.statistics.chart.min-price'))
        ->assertSee('0 BTC')
        ->assertSee(trans('pages.statistics.chart.max-price'))
        ->assertSee('0 BTC')
        ->assertSee('[0.03424,0.05805,0.0659,0.08981,0.0747,0.05936,0.068,0.06824,0.0602,0.06607,0.0625,0.05651,0.05737,0.05265,0.06036,0.07239,0.07024,0.07427,0.07767,0.07896,0.08689,0.09701,0.1294,0.1395,0.2469,0.2815,0.2507,0.2171,0.2601,0.236,0.2474,0.1985,0.1901,0.1997,0.1809,0.1673,0.1701,0.202,0.201,0.192,0.1889,0.2169,0.2304,0.2245,0.2443,0.255,0.2364,0.2463,0.218,0.2225,0.2225,0.2022,0.2247,0.2228,0.2114,0.179,0.1819,0.205,0.227,0.2087,0.2351,0.2386,0.2613,0.3206,0.2462,0.2775,0.212,0.2375,0.2333,0.2261,0.258,0.3016,0.3951,0.4353,0.5048,0.7036,0.804,0.9735,0.9516,1.05,0.8991,0.892,0.7349,0.904,0.7402,0.7073,0.7884,0.823,0.7349,0.7578,0.7575,0.702,0.7624,0.8012,0.7097,0.6812,0.6086,0.6384,0.6444,0.6112,0.5455,0.522,0.5415,0.5196,0.5941,0.7453,0.6985,0.5958,0.6358,0.5653,0.3992,0.3726,0.4398,0.459,0.4189,0.351,0.3292,0.4246,0.4666,0.4399,0.5669,0.531,0.668,0.6197,0.5864,0.5049,0.4793,0.4843,0.4353,0.4855,0.4866,0.5017,0.5999,0.5757,0.6612,0.7136,0.892,0.9383,0.8961,0.8279,0.8238,0.9171,0.858,0.9365,0.8649,1.679,1.728,1.562,1.298,1.56,1.593,1.657,1.81,1.753,1.63,1.579,1.576,1.717,1.979,2.617,2.574,2.38,2.4,2.537,2.358,2.561,2.243,2.5,2.612,2.643,2.566,2.813,2.96,3.716,3.685,3.541,3.538,3.944,3.577,3.301,3.698,3.239,3.117,2.718,2.809,3.156,3.004,3.165,2.945,3.201,2.959,2.757,2.992,2.898,2.793,2.791,2.493,2.745,2.592,2.528,2.212,2.384,2.595,2.833,2.662,2.629,2.836,2.862,2.767,2.817,2.824,2.871,2.775,2.564,2.637,2.53,2.86,2.587,2.526,2.519,2.432,2.436,2.422,2.443,2.097,2.048,2.496,2.322,2.363,2.54,2.533,2.915,3.236,2.876,2.883,2.57,2.911,3.188,3.186,3.117,2.965,3.2,3.147,3.135,3.097,3.112,2.997,3.061,3.176,3.505,3.776,3.427,2.924,3.069,3.405,3.645,4.051,4.211,4.575,4.184,3.576,3.928,3.755,3.434,3.743,4.285,4.415,4.501,4.267,4.985,5.91,6.815,6.405,7.493,7.886,5.771,6.585,6.288,7.068,7.861,7.357,6.897,7.867,6.474,6.99,7.563,7.842,7.542,7.027,6.814,7.803,8.022,7.915,9.324,10.29,8.234,8.894,8.972,8.032,7.785,5.566,6.2,6.295,6.534,7.124,5.939,5.414,6.017,6.78,7.236,6.772,6.635,6.568,6.599,5.457,5.664,4.803,4.607,5.024,4.193,3.179,3.76,3.513,3.787,4.197,4.041,3.756,4.055,4.081,4.47,4.908,4.852,4.987,4.533,4.651,4.111,4.075,3.728,3.91,3.607,3.686,3.774,3.773,3.584,3.682,4.02,4.434,4.181,4.005,3.735,3.483,3.189,3.207,3.071,3.531,3.218,3.358,2.831,2.868,2.832,2.509,2.42,2.75,2.849,2.752]');
});
