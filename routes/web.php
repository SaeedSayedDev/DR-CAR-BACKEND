<?php

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Http\Controllers\Web\ItemController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BookingAdController;
use App\Http\Controllers\Web\BookingServiceController;
use App\Http\Controllers\Web\BookingWinchController;
use App\Http\Controllers\Web\CarController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CommissionController;
use App\Http\Controllers\Web\CouponController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ExportController;
use App\Http\Controllers\Web\MessageController;
use App\Http\Controllers\Web\PriceController;
use App\Http\Controllers\Web\ProviderController;
use App\Http\Controllers\Web\SlideController;
use App\Http\Controllers\Web\TaxController;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\WalletController;
use App\Http\Controllers\Web\WalletTransactionController;
use App\Http\Controllers\Web\WithdrawController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('success', [BookingController::class, 'success']);

Route::get('success', [ServiceController::class, 'success']);
Route::get('error', [ServiceController::class, 'error']);

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    Route::group(['middleware' => 'guest:web'], function () {
        Route::view('login', 'auth.login')->name('login.page');
        Route::post('login', [AuthController::class, 'login'])->name('login.store');
        Route::view('password/forget', 'auth.passwords.email');
        Route::post('password/email', [AuthController::class, 'forgetPassword']);
        Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.reset');
        Route::get('reset-password/{otp}', [AuthController::class, 'pageResetPassword']);
    });

    Route::group(['middleware' => 'auth:web'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('password/update', [AuthController::class, 'updatePassword'])->name('password.update');
        Route::post('admin/update', [AuthController::class, 'updateAdmin'])->name('admin.update');
        Route::post('logo/update', [AuthController::class, 'updateLogo'])->name('logo.update');

        Route::get('/', DashboardController::class);
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        # App Management
        Route::resource('eProviders', ProviderController::class);
        Route::resource('items', ItemController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('booking/service', BookingServiceController::class)->name('booking.service');
        Route::get('booking/winch', BookingWinchController::class)->name('booking.winch');
        Route::resource('coupons', CouponController::class);
        # Payments
        Route::get('wallets', WalletController::class)->name('wallets');
        Route::get('walletTransactions', WalletTransactionController::class)->name('walletTransactions');
        Route::get('withdraws', [WithdrawController::class, 'index'])->name('withdraws.index');
        Route::post('withdraws/filter', [WithdrawController::class, 'filterStatus'])->name('withdraws.filter');
        Route::get('withdraws/{id}', [WithdrawController::class, 'show'])->name('withdraws.show');
        Route::put('withdraws/status/{id}', [WithdrawController::class, 'updateStatus'])->name('withdraws.status.update');
        # Settings
        Route::resource('slides', SlideController::class);
        Route::post('users/message', [UserController::class, 'message'])->name('users.message');
        Route::put('users/{id}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::put('users/{id}/unban', [UserController::class, 'unban'])->name('users.unban');
        Route::view('users/profile', 'settings.users.profile')->name('users.profile');
        Route::resource('users', UserController::class);
        Route::resource('taxes', TaxController::class);
        Route::resource('commissions', CommissionController::class);
        # Marketing
        Route::resource('prices', PriceController::class);
        Route::resource('cars', CarController::class);
        Route::get('booking-ads', [BookingAdController::class, 'index'])->name('booking-ads.index');
        Route::get('booking-ads/{bookingAd}', [BookingAdController::class, 'show'])->name('booking-ads.show');
        Route::put('booking-ads/{bookingAd}/approve', [BookingAdController::class, 'approve'])->name('booking-ads.approve');
        Route::put('booking-ads/{bookingAd}/reject', [BookingAdController::class, 'reject'])->name('booking-ads.reject');
    });
});

Route::get('bookings', function () {
    dd('bookings');
})->name('bookings.index');
Route::get('/favorites', function () {
    dd('favorites');
})->name('favorites.index');
Route::get('/notifications', function () {
    dd('notifications');
})->name('notifications.index');
Route::get('modules', function () {
    dd('modules');
})->name('modules.index');

Route::get('eProviderTypes', function () {
    dd('eProviderTypes');
})->name('eProviderTypes.index');

Route::get('EProviderDocuments', function () {
    dd('EProviderDocuments');
})->name('documents.index');

Route::get('requestedEProviders', function () {
    dd('requestedEProviders');
})->name('requestedEProviders.index');

Route::get('earnings', function () {
    dd('earnings');
})->name('earnings.index');
Route::get('earnings', function () {
    dd('earnings');
})->name('earnings.index');

Route::get('payments', function () {
    dd('payments');
})->name('payments.index');

// Route::put('eProvider/edit', function () {
//     dd('eProvider-edit');
// })->name('eProviders.edit');

Route::post('galleries', function () {
    dd('galleries');
})->name('galleries.index');
Route::post('awards', function () {
    dd('awards');
})->name('awards.index');


Route::get('exportPDF', [ExportController::class, 'exportPDF']);


// Route::get('aed', function () {
//     $originLat = 29.817446;
//     $originLng = 31.238099;
//     $destinationLat = 29.472148;
//     $destinationLng = 30.880290;
//     // $originLat = 30.050979; // Latitude of origin
//     // $originLng = 31.234700; // Longitude of origin
//     // $destinationLat = 29.808785; // Latitude of destination
//     // $destinationLng = 31.266972; // Longitude of destination
//     $apiKey = 'AIzaSyBss8QIwWZ9Q3E-ziCVDsQOOvYWI3tDPfA';

//     function getDistance($originLat, $originLng, $destinationLat, $destinationLng, $apiKey)
//     {
//         $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=$destinationLat,$destinationLng&origins=$originLat,$originLng&key=$apiKey";
//         $response = file_get_contents($url);
//         $data = json_decode($response, true);
//         // return $data;
//         if ($data['status'] == 'OK') {
//             return $data['rows'][0]['elements'][0]['distance']['value'] /1000; // Distance in meters
//         } else {
//             return false;
//         }
//     }

//     // Example usage

//     return $distance = getDistance($originLat, $originLng, $destinationLat, $destinationLng, $apiKey);
//     if ($distance !== false) {
//         echo "Distance between the two places: " . ($distance / 1000) . " kilometers";
//     } else {
//         echo "Failed to retrieve distance";
//     }
//     // AIzaSyBss8QIwWZ9Q3E-ziCVDsQOOvYWI3tDPfA
// });
