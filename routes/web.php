<?php

use Illuminate\Support\Facades\Route;

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
})->middleware('referral');

Auth::routes();

Route::get('/telegram/redirect', [App\Http\Controllers\AuthController::class, 'getUser'])->name('getuser');
Route::get('/telegram/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');



// DASHBOARD ROUTES
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/{vue_capture?}', function () {
        return view('home');
    })->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
});


// TOKEN SALE ROUTES
Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
Route::get('/wallet/users', [App\Http\Controllers\UsersController::class, 'index'])->name('wallet.users')->middleware('admin');


// API ROUTES
Route::post('/api/deposit', [App\Http\Controllers\ApiController::class, 'deposit']);
Route::post('/api/orders/create', [App\Http\Controllers\ApiController::class, 'createOrder']);
Route::post('/api/orders/{id}/confirm', [App\Http\Controllers\ApiController::class, 'confirmOrder'])->middleware('admin');
Route::post('/api/orders/{id}/decline', [App\Http\Controllers\ApiController::class, 'declineOrder'])->middleware('admin');
Route::post('/api/withdraw-payment', [App\Http\Controllers\ApiController::class, 'withdrawPayment'])->middleware('admin');
Route::post('/api/orders/assigneeOrder', [App\Http\Controllers\ApiController::class, 'assigneeOrderByUser']);
Route::post('/api/orders/declineOrder', [App\Http\Controllers\ApiController::class, 'declineOrderByUser']);
Route::post('/api/start_token_sale/', [App\Http\Controllers\ApiController::class, 'startTokenSale'])->middleware('admin');

// ADMIN PAGES
Route::get('/wallet/orders/', [App\Http\Controllers\WalletController::class, 'orders'])->middleware('admin')->name('wallet.orders');
Route::get('/wallet/stages/', [App\Http\Controllers\WalletController::class, 'stages'])->middleware('admin')->name('wallet.stages');
Route::get('/wallet/reports/', [App\Http\Controllers\WalletController::class, 'reports'])->middleware('admin')->name('wallet.reports');

