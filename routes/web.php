<?php

use AmrShawky\LaravelCurrency\Facade\Currency;
use App\Http\Controllers\Web\ItemController;
use App\Http\Controllers\Web\AddressController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\BookingAdController;
use App\Http\Controllers\Web\BookingServiceController;
use App\Http\Controllers\Web\BookingWinchController;
use App\Http\Controllers\Web\CarController;
use App\Http\Controllers\Web\CarLicenseController;
use App\Http\Controllers\Web\CarReportController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CommissionController;
use App\Http\Controllers\Web\CouponController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\ImageController;
use App\Http\Controllers\Web\NotificationController;
use App\Http\Controllers\Web\ExportController;
use App\Http\Controllers\Web\MessageController;
use App\Http\Controllers\Web\PriceController;
use App\Http\Controllers\Web\ProviderController;
use App\Http\Controllers\Web\ServiceController;
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

        # Menu:
        Route::get('/', DashboardController::class);
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

        # App Management
        Route::get('categories/category/{category}', [CategoryController::class, 'category'])->name('categories.category');
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
        // Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::patch('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        // Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('items/category/{category}', [ItemController::class, 'category'])->name('items.category');
        Route::get('items', [ItemController::class, 'index'])->name('items.index');
        Route::get('items/create', [ItemController::class, 'create'])->name('items.create');
        Route::post('items', [ItemController::class, 'store'])->name('items.store');
        // Route::get('items/{item}', [ItemController::class, 'show'])->name('items.show');
        Route::get('items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
        Route::patch('items/{item}', [ItemController::class, 'update'])->name('items.update');
        // Route::delete('items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

        Route::get('eServices/service/{service}', [ServiceController::class, 'service'])->name('eServices.service');
        Route::get('eServices/user/{user}', [ServiceController::class, 'user'])->name('eServices.user');
        Route::get('eServices/{service}/approve', [ServiceController::class, 'approve'])->name('eServices.approve');
        Route::get('eServices/{service}/reject', [ServiceController::class, 'reject'])->name('eServices.reject');
        Route::get('eServices', [ServiceController::class, 'index'])->name('eServices.index');
        Route::get('eServices/create', [ServiceController::class, 'create'])->name('eServices.create');
        Route::post('eServices', [ServiceController::class, 'store'])->name('eServices.store');
        // Route::get('eServices/{eService}', [ServiceController::class, 'show'])->name('eServices.show');
        Route::get('eServices/{eService}/edit', [ServiceController::class, 'edit'])->name('eServices.edit');
        Route::patch('eServices/{eService}', [ServiceController::class, 'update'])->name('eServices.update');
        // Route::delete('eServices/{eService}', [ServiceController::class, 'destroy'])->name('eServices.destroy');

        Route::get('eProviders/provider/{provider}', [ProviderController::class, 'provider'])->name('eProviders.provider');
        Route::get('eProviders', [ProviderController::class, 'index'])->name('eProviders.index');
        Route::get('eProviders/create', [ProviderController::class, 'create'])->name('eProviders.create');
        Route::post('eProviders', [ProviderController::class, 'store'])->name('eProviders.store');
        // Route::get('eProviders/{eProvider}', [ProviderController::class, 'show'])->name('eProviders.show');
        Route::get('eProviders/{eProvider}/edit', [ProviderController::class, 'edit'])->name('eProviders.edit');
        Route::patch('eProviders/{eProvider}', [ProviderController::class, 'update'])->name('eProviders.update');
        // Route::delete('eProviders/{eProvider}', [ProviderController::class, 'destroy'])->name('eProviders.destroy');

        Route::get('addresses', [AddressController::class, 'index'])->name('addresses.index');
        Route::get('addresses/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::post('addresses', [AddressController::class, 'store'])->name('addresses.store');
        // Route::delete('addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
        Route::get('addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
        Route::patch('addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        // Route::get('addresses/{address}', [AddressController::class, 'show'])->name('addresses.show');

        # Payments
        Route::get('booking/service', BookingServiceController::class)->name('booking.service.index');
        Route::get('booking/winch', BookingWinchController::class)->name('booking.winch.index');
        Route::get('booking/ads/user/{user}', [BookingAdController::class, 'user'])->name('booking.ads.user');
        Route::get('booking/ads', [BookingAdController::class, 'index'])->name('booking.ads.index');
        // Route::get('booking/ads/{bookingAd}', [BookingAdController::class, 'show'])->name('booking.ads.show');
        Route::get('booking/ads/{bookingAd}/approve', [BookingAdController::class, 'approve'])->name('booking.ads.approve');
        Route::get('booking/ads/{bookingAd}/reject', [BookingAdController::class, 'reject'])->name('booking.ads.reject');

        Route::get('wallets', [WalletController::class, 'index'])->name('wallets');
        Route::get('wallets/wallet/{wallet}', [WalletController::class, 'wallet'])->name('wallets.wallet');

        Route::get('walletTransactions', WalletTransactionController::class)->name('walletTransactions');

        Route::post('withdraws/filter', [WithdrawController::class, 'filterStatus'])->name('withdraws.filter');
        // Route::get('withdraws/{id}', [WithdrawController::class, 'show'])->name('withdraws.show');
        Route::get('withdraws', [WithdrawController::class, 'index'])->name('withdraws.index');
        Route::put('withdraws/status/{id}', [WithdrawController::class, 'updateStatus'])->name('withdraws.status.update');

        # Cars
        Route::get('cars/ad/{bookingAd}', [CarController::class, 'ad'])->name('cars.ad');
        Route::get('cars', [CarController::class, 'index'])->name('cars.index');
        Route::get('cars/create', [CarController::class, 'create'])->name('cars.create');
        Route::post('cars', [CarController::class, 'store'])->name('cars.store');
        // Route::get('cars/{car}', [CarController::class, 'show'])->name('cars.show');
        Route::get('cars/{car}/edit', [CarController::class, 'edit'])->name('cars.edit');
        Route::patch('cars/{car}', [CarController::class, 'update'])->name('cars.update');
        // Route::delete('cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');

        Route::get('carLicenses/user/{user}', [CarLicenseController::class, 'user'])->name('carLicenses.user');
        Route::get('carLicenses', [CarLicenseController::class, 'index'])->name('carLicenses.index');

        Route::get('carReports/attachments/{id}', [CarReportController::class, 'attachments'])->name('carReports.attachments');
        Route::get('carReports/report/{carLicense}', [CarReportController::class, 'report'])->name('carReports.report');
        Route::get('carReports/user/{user}', [CarReportController::class, 'user'])->name('carReports.user');
        Route::get('carReports', [CarReportController::class, 'index'])->name('carReports.index');

        # Settings
        Route::get('users/user/{user}', [UserController::class, 'user'])->name('users.user');
        Route::post('users/message', [UserController::class, 'message'])->name('users.message');
        Route::put('users/{id}/ban', [UserController::class, 'ban'])->name('users.ban');
        Route::put('users/{id}/unban', [UserController::class, 'unban'])->name('users.unban');
        Route::view('users/profile', 'settings.users.profile')->name('users.profile');
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::patch('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

        Route::get('coupons', [CouponController::class, 'index'])->name('coupons.index');
        Route::get('coupons/create', [CouponController::class, 'create'])->name('coupons.create');
        Route::post('coupons', [CouponController::class, 'store'])->name('coupons.store');
        // Route::get('coupons/{coupon}', [CouponController::class, 'show'])->name('coupons.show');
        Route::get('coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupons.edit');
        Route::patch('coupons/{coupon}', [CouponController::class, 'update'])->name('coupons.update');
        // Route::delete('coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy');

        Route::get('taxes', [TaxController::class, 'index'])->name('taxes.index');
        Route::get('taxes/{tax}/edit', [TaxController::class, 'edit'])->name('taxes.edit');
        Route::patch('taxes/{tax}', [TaxController::class, 'update'])->name('taxes.update');

        Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
        Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
        Route::patch('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');

        Route::get('prices', [PriceController::class, 'index'])->name('prices.index');
        Route::get('prices/{price}/edit', [PriceController::class, 'edit'])->name('prices.edit');
        Route::patch('prices/{price}', [PriceController::class, 'update'])->name('prices.update');

        Route::get('images', [ImageController::class, 'index'])->name('images.index');
        Route::put('images/{image}', [ImageController::class, 'update'])->name('images.update');

        // Route::resource('slides', SlideController::class);
    });

});

// Route::get('bookings', function () {
//     dd('bookings');
// })->name('bookings.index');
// Route::get('/favorites', function () {
//     dd('favorites');
// })->name('favorites.index');
// Route::get('/notifications', function () {
//     dd('notifications');
// })->name('notifications.index');
// Route::get('modules', function () {
//     dd('modules');
// })->name('modules.index');

// Route::get('eProviderTypes', function () {
//     dd('eProviderTypes');
// })->name('eProviderTypes.index');

// Route::get('EProviderDocuments', function () {
//     dd('EProviderDocuments');
// })->name('documents.index');

// Route::get('requestedEProviders', function () {
//     dd('requestedEProviders');
// })->name('requestedEProviders.index');

// Route::get('earnings', function () {
//     dd('earnings');
// })->name('earnings.index');
// Route::get('earnings', function () {
//     dd('earnings');
// })->name('earnings.index');

// Route::get('payments', function () {
//     dd('payments');
// })->name('payments.index');

// Route::put('eProvider/edit', function () {
//     dd('eProvider-edit');
// })->name('eProviders.edit');

// Route::post('galleries', function () {
//     dd('galleries');
// })->name('galleries.index');
// Route::post('awards', function () {
//     dd('awards');
// })->name('awards.index');


// Route::get('exportPDF', [ExportController::class, 'exportPDF']);


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
