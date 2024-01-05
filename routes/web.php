<?php

use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Models\Address;
use Illuminate\Support\Facades\Route;

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

Route::get('success', [BookingController::class, 'success']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');


Route::get('reset-password/{otp}', [AuthController::class, 'pageResetPassword'])->name('page.resetPassword');

Route::get('error', [BookingController::class, 'error']);

Route::get('/calculateDistance', function () {
    function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Radius of the Earth in kilometers

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;
        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) *
                pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius; // Distance in kilometers
    }
    $address1Lat = 29.817446293635328; // Replace with the latitude of address 1
    $address1Lon = 31.23809960860361; // Replace with the longitude of address 1

    $address2Lat = 29.81211668989651; // Replace with the latitude of address 2
    $address2Lon = 31.266520500000006; // Replace with the longitude of address 2

    $distance = calculateDistance($address1Lat, $address1Lon, $address2Lat, $address2Lon);

    return "The distance between the addresses is approximately " . round($distance, 2) . " kilometers.";
});

Route::get('/logout', function () {
    dd('logout');
});
Route::get('/', function () {
    return view('dashboard.index');
});
Route::get('/dashboard', function () {
    return view('dashboard.index');
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

Route::get('eProviders', function () {
    dd('eProviders');
})->name('eProviders.index');

Route::get('users', function () {
    dd('users');
})->name('users.index');

Route::get('user/profile', function () {
    dd('users');
})->name('users.profile');

Route::get('payments', function () {
    dd('payments');
})->name('payments.index');

Route::put('eProvider/edit', function () {
    dd('eProvider-edit');
})->name('eProviders.edit');

Route::post('galleries', function () {
    dd('galleries');
})->name('galleries.index');
Route::post('awards', function () {
    dd('awards');
})->name('awards.index');