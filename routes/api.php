<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StatusOrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/confirm-email', [AuthController::class, 'confirmCodeEmail']);

Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Route::group(['middleware' => 'IsEnable'], function () {
Route::post('user/login', [AuthController::class, 'login'])->middleware('checkTypeUser')->name('login.user');
Route::post('provider/login', [AuthController::class, 'login'])->middleware('checkTypeProvider')->name('login.provider');
// });



Route::group(['middleware' => 'apiAuth'], function () {

    Route::group(['middleware' => 'checkTypeUser'], function () {

        Route::post('review/store', [ReviewController::class, 'store']);
        Route::put('review/update/{id}', [ReviewController::class, 'update']);
        Route::delete('review/delete/{id}', [ReviewController::class, 'delete']);

        Route::post('favourite/store', [FavouriteController::class, 'store']);
        Route::delete('favourite/delete/{id}', [FavouriteController::class, 'delete']);

        Route::post('booking/service', [ServiceController::class, 'bookingService']);
        Route::post('pay/booking/service/{id}', [ServiceController::class, 'payBookingSerivice']);
    });


    Route::group(['middleware' => 'checkTypeProvider'], function () {

        Route::post('service/store', [ServiceController::class, 'store'])->name('service.store');
        Route::put('service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::delete('service/delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');

        Route::get('coupons', [ServiceController::class, 'indexCoupon'])->name('coupons');
        Route::get('coupon/show/{id}', [ServiceController::class, 'showCoupon'])->name('coupon.show');
        Route::post('coupon/store', [ServiceController::class, 'storeCoupon'])->name('coupon.store');
        Route::put('coupon/update/{id}', [ServiceController::class, 'updateCoupon'])->name('coupon.update');
        Route::delete('coupon/delete/{id}', [ServiceController::class, 'deleteCoupon'])->name('coupon.delete');
    });

    Route::post('change-password', [AuthController::class, 'changePassword']);

    Route::get('services', [ServiceController::class, 'index'])->name('services');
    Route::get('service/show/{id}', [ServiceController::class, 'show'])->name('service.show');

    Route::get('chats', [ChatController::class, 'index']);
    Route::post('chat/store', [ChatController::class, 'store']);
    Route::get('chat/show/{chat_id}', [ChatController::class, 'show']);
    Route::post('chatMessage/store', [ChatController::class, 'storeMessage']);

    Route::get('account/show', [AuthController::class, 'showAccount']);

    Route::put('account/update', [AuthController::class, 'updateAccount']);
    Route::delete('account/delete', [AuthController::class, 'deleteAccount']);

    Route::post('charge/wallet', [WalletController::class, 'chargeWallet']);

    Route::post('WithdrawWallet/store', [WalletController::class, 'WithdrawWallet']);

    Route::get('WithdrawWallet/cancel/{id}', [WalletController::class, 'cancel']);
});


Route::get('categories', [CategoryController::class, 'index'])->name('categories');
Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('category/show/{id}', [CategoryController::class, 'show'])->name('category.show');
Route::put('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

Route::get('items', [ItemController::class, 'index'])->name('items');
Route::post('item/store', [ItemController::class, 'store'])->name('item.store');
Route::get('item/show/{id}', [ItemController::class, 'show'])->name('item.show');
Route::put('item/update/{id}', [ItemController::class, 'update'])->name('item.update');
Route::delete('item/delete/{id}', [ItemController::class, 'delete'])->name('item.delete');



Route::get('statusOrders', [StatusOrderController::class, 'index']);
Route::post('statusOrder/store', [StatusOrderController::class, 'store']);
Route::get('statusOrder/show/{id}', [StatusOrderController::class, 'show']);
Route::put('statusOrder/update/{id}', [StatusOrderController::class, 'update']);
Route::delete('statusOrder/delete/{id}', [StatusOrderController::class, 'delete']);


Route::get('slides', [SlideController::class, 'index']);
Route::post('slide/store', [SlideController::class, 'store']);
Route::get('slide/show/{id}', [SlideController::class, 'show']);
Route::put('slide/update/{id}', [SlideController::class, 'update']);
Route::delete('slide/delete/{id}', [SlideController::class, 'delete']);

Route::get('payment_methods', [PaymentMethodController::class, 'index'])->name('payment_methods');
Route::post('payment_method/store', [PaymentMethodController::class, 'store'])->name('payment_method.store');
Route::get('payment_method/show/{id}', [PaymentMethodController::class, 'show'])->name('payment_method.show');
Route::put('payment_method/update/{id}', [PaymentMethodController::class, 'update'])->name('payment_method.update');
Route::delete('payment_method/delete/{id}', [PaymentMethodController::class, 'delete'])->name('payment_method.delete');


Route::put('withdraw/confirm/{withdraw_id}', [WalletController::class, 'confirm_admin']);

Route::post('/artisanOrder', [SettingController::class, 'artisanOrder'])->name('artisanOrder');

// Route::get('fixer', function () {
//     $apiUrl = "https://api.fixer.io/latest?access_key=" . env('FIXER_API_KEY');

//     $response = Http::withHeaders([
//         'apikey' => env('FIXER_API_KEY'),
//     ])->get('https://api.apilayer.com/fixer/convert', [
//         'from' => 'AED',
//         'to' => 'USD',
//         'amount' => 100,
//         'date' =>  date('Y-m-d'),
//     ]);
//     return $response['result'];
// });