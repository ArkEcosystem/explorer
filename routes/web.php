<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Route::get("/wallets/{address}", "");
// Route::get("/wallets/{address}/voters", "");
// Route::get("/wallets/{address}/voters/{page}", "");
// Route::get("/wallets/{address}/blocks", "");
// Route::get("/wallets/{address}/blocks/{page}", "");
// Route::get("/wallets/{address}/transactions", "");
// Route::get("/wallets/{address}/transactions/{type}", "");
// Route::get("/wallets/{address}/transactions/{type}/{page}", "");
// Route::get("/block/{id}", "");
// Route::get("/block/{id}/transactions", "");
// Route::get("/block/{id}/transactions/{page}", "");
// Route::get("/blocks", "");
// Route::get("/blocks/{page}", "");
// Route::get("/transaction/{id}", "");
// Route::get("/transactions", "");
// Route::get("/transactions/{page}", "");
// Route::get("/delegate-monitor", "");
// Route::get("/top-wallets", "");
// Route::get("/top-wallets/{page}", "");
