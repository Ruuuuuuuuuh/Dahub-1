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
    if (Auth::check()) {
        return redirect(env('AUTH_REDIRECT'));
    } else return view('welcome');
})->middleware('referral');

Auth::routes();

Route::get('/telegram/redirect', [App\Http\Controllers\AuthController::class, 'getUser'])->name('getuser');
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/auth/{token}', [App\Http\Controllers\AuthController::class, 'authUser'])->name('auth');



// WALLET ROUTES
Route::group(['prefix' => 'wallet'], function () {
    Route::get('/', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
    Route::get('/orders/{id}', [App\Http\Controllers\WalletController::class, 'getOrder'])->name('getOrder');
    Route::get('/orders/{id}/accept', [App\Http\Controllers\WalletController::class, 'acceptOrderPage']);
    Route::get('/settings/', [App\Http\Controllers\WalletController::class, 'settings'])->name('settings');
    Route::get('/history/', [App\Http\Controllers\WalletController::class, 'history'])->name('history');
    Route::get('/system/', [App\Http\Controllers\WalletController::class, 'systemConfigPage'])->name('systemConfigPage')->middleware('admin');
    Route::get('/test/', [App\Http\Controllers\WalletController::class, 'testPage'])->name('testPage')->middleware('admin');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::get('/explorer', [App\Http\Controllers\DashboardController::class, 'explorer'])->name('dashboard.explorer');
    Route::get('/orders/{id}', [App\Http\Controllers\DashboardController::class, 'order'])->name('dashboard.pages.order');
    Route::get('/transfer', [App\Http\Controllers\DashboardController::class, 'transfer'])->name('dashboard.transfer');

    // ADMIN PAGES
    Route::post('/currencies/{slug}', [App\Http\Controllers\DashboardController::class, 'updateCurrency'])->middleware('admin');
    Route::get('/orders/', [App\Http\Controllers\DashboardController::class, 'orders'])->middleware('gate_manager')->name('dashboard.orders');
    Route::get('/stages/', [App\Http\Controllers\DashboardController::class, 'stages'])->middleware('admin')->name('dashboard.stages');
    Route::get('/reports/', [App\Http\Controllers\DashboardController::class, 'reports'])->middleware('admin')->name('dashboard.reports');
    Route::get('/reports/deposit', [App\Http\Controllers\DashboardController::class, 'reports'])->middleware('admin')->name('dashboard.reports.deposit');
    Route::get('/reports/withdraw', [App\Http\Controllers\DashboardController::class, 'reports'])->middleware('admin')->name('dashboard.reports.withdraw');
    Route::get('/hft/', [App\Http\Controllers\DashboardController::class, 'hft'])->middleware('admin')->name('dashboard.hft');
    Route::get('/currencies/', [App\Http\Controllers\DashboardController::class, 'currencies'])->middleware('admin')->name('dashboard.currencies');
    Route::get('/currencies/{slug}', [App\Http\Controllers\DashboardController::class, 'currency'])->middleware('admin')->name('dashboard.currency');
    Route::get('/payments/', [App\Http\Controllers\DashboardController::class, 'payments'])->middleware('admin')->name('dashboard.payments');
    Route::get('/users', [App\Http\Controllers\DashboardController::class, 'getUsers'])->name('dashboard.users')->middleware('gate_manager');
    Route::get('/gates', [App\Http\Controllers\DashboardController::class, 'gates'])->name('dashboard.gates')->middleware('gate_manager');
    Route::get('/tags', [App\Http\Controllers\DashboardController::class, 'tags'])->name('dashboard.tags')->middleware('admin');
    Route::get('/telegram', [App\Http\Controllers\DashboardController::class, 'telegram'])->name('dashboard.telegram')->middleware('admin');
    Route::get('/settings', [App\Http\Controllers\DashboardController::class, 'settings'])->name('dashboard.settings')->middleware('admin');
});

// ADMIN ROUTES
Route::post('/api/tags/', [App\Http\Controllers\SystemApiController::class, 'getTags'])->middleware('admin')->name('api.tags');
Route::post('/api/tags/add', [App\Http\Controllers\SystemApiController::class, 'addTag'])->middleware('admin');
Route::post('/api/tags/remove', [App\Http\Controllers\SystemApiController::class, 'removeTag'])->middleware('admin');
Route::post('/api/start_token_sale/', [App\Http\Controllers\SystemApiController::class, 'startTokenSale'])->middleware('admin');
Route::post('/api/generate_user_wallets/', [App\Http\Controllers\SystemApiController::class, 'generateUserWallets'])->middleware('admin');
Route::post('/api/orders/{id}/decline', [App\Http\Controllers\SystemApiController::class, 'declineOrder'])->middleware('gate_manager');
Route::post('/api/withdraw-payment', [App\Http\Controllers\SystemApiController::class, 'withdrawPayment'])->middleware('admin');
Route::post('/api/send', [App\Http\Controllers\SystemApiController::class, 'sendTokens'])->middleware('admin');
Route::post('/api/set_dhb_rate', [App\Http\Controllers\SystemApiController::class, 'setDHBRate'])->middleware('admin');
Route::post('/api/set_hft', [App\Http\Controllers\SystemApiController::class, 'setHFT'])->middleware('admin');
Route::post('/api/add_currency', [App\Http\Controllers\SystemApiController::class, 'addCurrency'])->middleware('admin');
Route::post('/api/add_payment', [App\Http\Controllers\SystemApiController::class, 'addPayment'])->middleware('admin');
Route::post('/api/attach_payment_to_currency', [App\Http\Controllers\SystemApiController::class, 'attachPaymentToCurrency'])->middleware('admin');
Route::post('/api/detach_payment_from_currency', [App\Http\Controllers\SystemApiController::class, 'detachPaymentFromCurrency'])->middleware('admin');
Route::post('/api/orders/admin/create', [App\Http\Controllers\SystemApiController::class, 'createOrder'])->middleware('admin');
Route::post('/api/set_dhb_per_user', [App\Http\Controllers\SystemApiController::class, 'setDHBPerUser'])->middleware('admin');
Route::post('/api/set_dhb_per_order', [App\Http\Controllers\SystemApiController::class, 'setDHBPerOrder'])->middleware('admin');
Route::post('/api/set_gate', [App\Http\Controllers\SystemApiController::class, 'setGate'])->middleware('gate_manager');
Route::post('/api/remove_gate', [App\Http\Controllers\SystemApiController::class, 'removeGate'])->middleware('gate_manager');
Route::post('/api/set-token-sale-date', [App\Http\Controllers\SystemApiController::class, 'setTokenSaleStartDate'])->middleware('admin');
Route::post('/api/telegram/send_message', [App\Http\Controllers\SystemApiController::class, 'sendMessageByTelegram'])->middleware('admin');
Route::post('/api/system/settings/update', [App\Http\Controllers\SystemApiController::class, 'updateSystemSettings'])->middleware('admin');

// API ROUTES
Route::get('/api/payment_details/get', [App\Http\Controllers\ApiController::class, 'getPaymentDetails']);
Route::post('/api/deposit', [App\Http\Controllers\ApiController::class, 'deposit']);
Route::post('/api/orders/create', [App\Http\Controllers\ApiController::class, 'createOrder']);
Route::post('/api/orders/assigneeOrder', [App\Http\Controllers\ApiController::class, 'assigneeOrderByUser']);
Route::post('/api/orders/declineOrder', [App\Http\Controllers\ApiController::class, 'declineOrderByUser']);
Route::post('/api/getTransactions', [App\Http\Controllers\ApiController::class, 'getTransactions']);
Route::post('/api/getPayments', [App\Http\Controllers\ApiController::class, 'getPayments']);
Route::post('/api/createOrderByUser', [App\Http\Controllers\ApiController::class, 'createOrderByUser']);
Route::post('/api/saveUserConfig', [App\Http\Controllers\ApiController::class, 'saveUserConfig']);
Route::post('/api/payment_details/add', [App\Http\Controllers\ApiController::class, 'addPaymentDetails']);
Route::post('/api/payment_details/edit', [App\Http\Controllers\ApiController::class, 'editPaymentDetails']);
Route::post('/api/payment_details/remove', [App\Http\Controllers\ApiController::class, 'removePaymentDetails']);
Route::post('/api/orders/acceptOrderByGate', [App\Http\Controllers\ApiController::class, 'acceptOrderByGate']);
Route::post('/api/orders/confirmOrderByGate', [App\Http\Controllers\ApiController::class, 'confirmOrderByGate']);
Route::post('/api/orders/confirmOrderByUser', [App\Http\Controllers\ApiController::class, 'confirmOrderByUser']);
Route::post('/api/orders/declineOrderByGate', [App\Http\Controllers\ApiController::class, 'declineOrderByGate']);
Route::post('/api/orders/acceptSendingByGate', [App\Http\Controllers\ApiController::class, 'acceptSendingByGate']);
Route::post('/api/orders/acceptSendingByUser', [App\Http\Controllers\ApiController::class, 'acceptSendingByUser']);
Route::post('/api/getOrdersByFilter', [App\Http\Controllers\ApiController::class, 'getOrdersByFilter']);
Route::post('/api/transfer', [App\Http\Controllers\ApiController::class, 'transfer']);


// Telegram Web Api
Route::post(\Telegram::getAccessToken().'/webhook', function () {
    Telegram::commandsHandler(true);
    return 'ok';
});
