<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\ChatController;
use Illuminate\Http\Request;
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


Route::post('/login', [AuthController::class, 'login'])->middleware('IsEnable');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/confirm-email', [AuthController::class, 'confirmCodeEmail']);

Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);


Route::group(['middleware' => 'apiAuth'], function () {
    Route::post('change-password', [AuthController::class, 'changePassword']);

    Route::get('/test', function () {
        dd('dd');
    });
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

Route::get('services', [ServiceController::class, 'index'])->name('services');
Route::post('service/store', [ServiceController::class, 'store'])->name('service.store');
Route::get('service/show/{id}', [ServiceController::class, 'show'])->name('service.show');
Route::put('service/update/{id}', [ServiceController::class, 'update'])->name('service.update');
Route::delete('service/delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');


Route::get('chats', [ChatController::class, 'index']);
Route::post('chat/store', [ChatController::class, 'store']);
Route::get('chat/show/{chat_id}', [ChatController::class, 'show']);
Route::post('chatMessage/store', [ChatController::class, 'storeMessage']);
