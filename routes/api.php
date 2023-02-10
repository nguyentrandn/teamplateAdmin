<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Users\UserController;
use App\Http\Controllers\Api\Users\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Register
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
});

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::controller(WishListController::class)->group(function () {
        Route::prefix('wish-list')->as('wishList.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('update', 'update')->name('update');
        });
    });

    Route::controller(UserController::class)->group(function () {
        Route::prefix('users')->as('users.')->group(function () {
            Route::get('profile', 'profile')->name('profile');
            Route::post('update-profile', 'updateProfile')->name('updateProfile');
        });
    });
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('refresh-token', 'refresh')->name('refresh');
        Route::post('change-password', 'changePassword');
    });
});
