<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

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
    if (Auth::check()) return redirect(route('wallet')); else return view('welcome');
})->middleware('referral');

Auth::routes();

Route::get('/telegram/redirect', [App\Http\Controllers\AuthController::class, 'getUser'])->name('getuser');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/auth/{token}', [App\Http\Controllers\AuthController::class, 'authUser'])->name('auth');



// DASHBOARD ROUTES
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/{vue_capture?}', function () {
        return view('home');
    })->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
});


Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
Route::get('/wallet/profile', [App\Http\Controllers\WalletController::class, 'profile'])->name('wallet.profile');

// ADMIN PAGES
Route::get('/wallet/orders/', [App\Http\Controllers\WalletController::class, 'orders'])->middleware('admin')->name('wallet.orders');
Route::get('/wallet/stages/', [App\Http\Controllers\WalletController::class, 'stages'])->middleware('admin')->name('wallet.stages');
Route::get('/wallet/reports/', [App\Http\Controllers\WalletController::class, 'reports'])->middleware('admin')->name('wallet.reports');
Route::post('/api/tags/', [App\Http\Controllers\SystemApiController::class, 'getTags'])->middleware('admin')->name('api.tags');

// ADMIN ROUTES
Route::get('/wallet/users', [App\Http\Controllers\UsersController::class, 'index'])->name('wallet.users')->middleware('admin');
Route::post('/api/start_token_sale/', [App\Http\Controllers\SystemApiController::class, 'startTokenSale'])->middleware('admin');
Route::post('/api/generate_user_wallets/', [App\Http\Controllers\SystemApiController::class, 'generateUserWallets'])->middleware('admin');
Route::post('/api/orders/{id}/confirm', [App\Http\Controllers\SystemApiController::class, 'confirmOrder'])->middleware('admin');
Route::post('/api/orders/{id}/decline', [App\Http\Controllers\SystemApiController::class, 'declineOrder'])->middleware('admin');
Route::post('/api/withdraw-payment', [App\Http\Controllers\SystemApiController::class, 'withdrawPayment'])->middleware('admin');
Route::post('/api/send', [App\Http\Controllers\SystemApiController::class, 'sendTokens'])->middleware('admin');
Route::post('/api/set_dhb_rate', [App\Http\Controllers\SystemApiController::class, 'setDHBRate'])->middleware('admin');
Route::post('/api/orders/admin/create', [App\Http\Controllers\SystemApiController::class, 'createOrder']);

// API ROUTES
Route::post('/api/deposit', [App\Http\Controllers\ApiController::class, 'deposit']);
Route::post('/api/orders/create', [App\Http\Controllers\ApiController::class, 'createOrder']);
Route::post('/api/orders/assigneeOrder', [App\Http\Controllers\ApiController::class, 'assigneeOrderByUser']);
Route::post('/api/orders/declineOrder', [App\Http\Controllers\ApiController::class, 'declineOrderByUser']);


// Telegram Web Api
Route::post(\Telegram::getAccessToken().'/webhook', function () {
    $update = Telegram::commandsHandler(true);
    return 'ok';
});
