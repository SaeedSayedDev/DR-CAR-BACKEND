<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\StatusOrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\WalletController;
use App\Models\Address;
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


Route::get('images/Category/{name}', [ImageController::class, 'imageCategory']);
Route::get('images/Item/{name}', [ImageController::class, 'imageItem']);

Route::get('images/Service/{name}', [ImageController::class, 'imageService']);
Route::get('images/Provider/{name}', [ImageController::class, 'imageProvider']);
Route::get('images/Slide/{name}', [ImageController::class, 'imageSlide']);
Route::get('images/Options/{name}', [ImageController::class, 'imageOptions']);




Route::post('/register', [AuthController::class, 'register']);
Route::post('/confirm-email', [AuthController::class, 'confirmCodeEmail']);

Route::post('/forget-password', [AuthController::class, 'forgetPassword']);

// Route::group(['middleware' => 'IsEnable'], function () {
Route::post('user/login', [AuthController::class, 'login'])->middleware('checkTypeUser')->name('login.user');
Route::post('provider/login', [AuthController::class, 'login'])->middleware('checkTypeProvider')->name('login.provider');
// });



Route::group(['middleware' => 'apiAuth'], function () {


    Route::group(['middleware' => 'checkTypeUser'], function () {

        Route::get('services', [ServiceController::class, 'index'])->name('services');

        Route::post('review/store', [ReviewController::class, 'store'])->name('review.service');
        Route::put('review/update/{id}', [ReviewController::class, 'update']);
        Route::delete('review/delete/{id}', [ReviewController::class, 'delete']);

        Route::get('favourites', [FavouriteController::class, 'index']);
        Route::post('favourite/store', [FavouriteController::class, 'store']);
        Route::delete('favourite/delete/{id}', [FavouriteController::class, 'delete']);

        Route::get('user/bookings', [ServiceController::class, 'getBookingsInUser']);
        Route::get('user/booking/show/{booking_id}', [ServiceController::class, 'showBookingInUser']);
        Route::post('booking/service', [ServiceController::class, 'bookingService']);
        Route::post('pay/booking/service/{id}', [ServiceController::class, 'payBookingSerivice']);
        Route::put('cancel/booking/{booking_id}', [ServiceController::class, 'cancelBooking']);


        Route::get('provider/show/{id}', [ProviderController::class, 'show'])->name('show.provider');
    });


    Route::group(['middleware' => 'checkTypeProvider'], function () {
        Route::get('garage/services', [ServiceController::class, 'indexGarage'])->name('services.garage');

        Route::post('service/store', [ServiceController::class, 'store'])->name('service.store');
        Route::put('service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
        Route::delete('service/delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');

        Route::post('options/store', [ServiceController::class, 'storeOPtion'])->name('options.store');
        Route::put('options/update/{id}', [ServiceController::class, 'updateOption'])->name('options.update');

        Route::get('coupons', [ServiceController::class, 'indexCoupon'])->name('coupons');
        Route::get('coupon/show/{id}', [ServiceController::class, 'showCoupon'])->name('coupon.show');
        Route::post('coupon/store', [ServiceController::class, 'storeCoupon'])->name('coupon.store');
        Route::put('coupon/update/{id}', [ServiceController::class, 'updateCoupon'])->name('coupon.update');
        Route::delete('coupon/delete/{id}', [ServiceController::class, 'deleteCoupon'])->name('coupon.delete');

        Route::post('garageData/store', [AuthController::class, 'storeGarageData'])->name('garageData');
        Route::post('availabilityTime/store', [AuthController::class, 'availabilityTime'])->name('availabilityTime');

        Route::get('garage/bookings', [ServiceController::class, 'getBookingsInGarage']);
        Route::post('garage/updateBooking/{id}', [ServiceController::class, 'updateBookingService']);
    });

    Route::get('booking/show/{booking_id}', [ServiceController::class, 'showBooking']);

    Route::get('booking/show/{booking_id}', [ServiceController::class, 'showBooking']);

    Route::get('me', [AuthController::class, 'me'])->name('me');

    Route::post('change-password', [AuthController::class, 'changePassword']);

    Route::get('services', [ServiceController::class, 'index'])->name('services');
    Route::get('services/availability', [ServiceController::class, 'servicesAvailability'])->name('services.availability');
    Route::get('service/show/{id}', [ServiceController::class, 'show'])->name('service.show');

    // Route::get('chats', [ChatController::class, 'index']);
    // Route::post('chat/store', [ChatController::class, 'store']);
    // Route::get('chat/show/{chat_id}', [ChatController::class, 'show']);
    // Route::post('chatMessage/store', [ChatController::class, 'storeMessage']);


    Route::put('account/update', [AuthController::class, 'updateAccount']);
    Route::delete('account/delete', [AuthController::class, 'deleteAccount']);

    Route::post('charge/wallet', [WalletController::class, 'chargeWallet']);

    Route::post('WithdrawWallet/store', [WalletController::class, 'WithdrawWallet']);

    Route::get('WithdrawWallet/cancel/{id}', [WalletController::class, 'cancel']);

    Route::get('addresses', [AddressController::class, 'index']);
    Route::post('address/store', [AddressController::class, 'store']);
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
// Route::get('env/data', [SettingController::class, 'Dotenv'])->name('Dotenv');
Route::get('env/data', function () {
    dd(Dotenv\Dotenv::createArrayBacked(base_path())->load());
});

Route::get('fixer', function () {
    $delimiter = ',';
    $array = explode($delimiter, '1,2,3'); // Split the string into an array
    return $array;
});