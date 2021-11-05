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
/*Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/{vue_capture?}', function () {
        return view('dashboard');
    })->where('vue_capture', '[\/\w\.-]*')->middleware('auth');
});*/
Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('main');
    Route::get('/orders/{id}', [App\Http\Controllers\DashboardController::class, 'getOrder'])->name('getOrder');
});

Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
Route::get('/wallet/profile', [App\Http\Controllers\WalletController::class, 'profile'])->name('wallet.profile');
Route::get('/wallet/explorer', [App\Http\Controllers\WalletController::class, 'explorer'])->name('wallet.explorer');

// ADMIN PAGES
Route::get('/wallet/orders/', [App\Http\Controllers\WalletController::class, 'orders'])->middleware('admin')->name('wallet.orders');
Route::get('/wallet/stages/', [App\Http\Controllers\WalletController::class, 'stages'])->middleware('admin')->name('wallet.stages');
Route::get('/wallet/reports/', [App\Http\Controllers\WalletController::class, 'reports'])->middleware('admin')->name('wallet.reports');
Route::get('/wallet/hft/', [App\Http\Controllers\WalletController::class, 'hft'])->middleware('admin')->name('wallet.hft');
Route::get('/wallet/currencies/', [App\Http\Controllers\WalletController::class, 'currencies'])->middleware('admin')->name('wallet.currencies');
Route::get('/wallet/currencies/{slug}', [App\Http\Controllers\WalletController::class, 'currency'])->middleware('admin')->name('wallet.currency');
Route::get('/wallet/payments/', [App\Http\Controllers\WalletController::class, 'payments'])->middleware('admin')->name('wallet.payments');
Route::get('/wallet/users', [App\Http\Controllers\UsersController::class, 'index'])->name('wallet.users')->middleware('admin');

// ADMIN ROUTES
Route::post('/api/tags/', [App\Http\Controllers\SystemApiController::class, 'getTags'])->middleware('admin')->name('api.tags');
Route::post('/api/start_token_sale/', [App\Http\Controllers\SystemApiController::class, 'startTokenSale'])->middleware('admin');
Route::post('/api/generate_user_wallets/', [App\Http\Controllers\SystemApiController::class, 'generateUserWallets'])->middleware('admin');
Route::post('/api/orders/{id}/confirm', [App\Http\Controllers\SystemApiController::class, 'confirmOrder'])->middleware('admin');
Route::post('/api/orders/{id}/decline', [App\Http\Controllers\SystemApiController::class, 'declineOrder'])->middleware('admin');
Route::post('/api/withdraw-payment', [App\Http\Controllers\SystemApiController::class, 'withdrawPayment'])->middleware('admin');
Route::post('/api/send', [App\Http\Controllers\SystemApiController::class, 'sendTokens'])->middleware('admin');
Route::post('/api/set_dhb_rate', [App\Http\Controllers\SystemApiController::class, 'setDHBRate'])->middleware('admin');
Route::post('/api/set_hft', [App\Http\Controllers\SystemApiController::class, 'setHFT'])->middleware('admin');
Route::post('/api/add_currency', [App\Http\Controllers\SystemApiController::class, 'addCurrency'])->middleware('admin');
Route::post('/api/add_payment', [App\Http\Controllers\SystemApiController::class, 'addPayment'])->middleware('admin');
Route::post('/api/attach_payment_to_currency', [App\Http\Controllers\SystemApiController::class, 'attachPaymentToCurrency'])->middleware('admin');
Route::post('/api/orders/admin/create', [App\Http\Controllers\SystemApiController::class, 'createOrder'])->middleware('admin');

// API ROUTES
Route::post('/api/deposit', [App\Http\Controllers\ApiController::class, 'deposit']);
Route::post('/api/orders/create', [App\Http\Controllers\ApiController::class, 'createOrder']);
Route::post('/api/orders/assigneeOrder', [App\Http\Controllers\ApiController::class, 'assigneeOrderByUser']);
Route::post('/api/orders/declineOrder', [App\Http\Controllers\ApiController::class, 'declineOrderByUser']);
Route::post('/api/getTransactions', [App\Http\Controllers\ApiController::class, 'getTransactions']);
Route::post('/api/getPayments', [App\Http\Controllers\ApiController::class, 'getPayments']);
Route::post('/api/createOrderByUser', [App\Http\Controllers\ApiController::class, 'createOrderByUser']);
Route::post('/api/saveUserConfig', [App\Http\Controllers\ApiController::class, 'saveUserConfig']);
Route::post('/api/payment_details/add', [App\Http\Controllers\ApiController::class, 'addPaymentDetails']);
Route::post('/api/payment_details/get', [App\Http\Controllers\ApiController::class, 'getPaymentDetails']);
Route::post('/api/orders/acceptOrderByGate', [App\Http\Controllers\ApiController::class, 'acceptOrderByGate']);
Route::post('/api/orders/confirmOrderByGate', [App\Http\Controllers\ApiController::class, 'confirmOrderByGate']);
Route::post('/api/orders/confirmOrderByUser', [App\Http\Controllers\ApiController::class, 'confirmOrderByUser']);
Route::post('/api/orders/declineOrderByGate', [App\Http\Controllers\ApiController::class, 'declineOrderByGate']);
Route::post('/api/orders/acceptSendingByGate', [App\Http\Controllers\ApiController::class, 'acceptSendingByGate']);


// Telegram Web Api
Route::post(\Telegram::getAccessToken().'/webhook', function () {
    $update = Telegram::commandsHandler(true);
    return 'ok';
});
