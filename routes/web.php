<?php

use App\Http\Controllers\Admin\ServiceController;
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

Route::get('success', [ServiceController::class, 'success']);
Route::get('error', [ServiceController::class, 'error']);



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
