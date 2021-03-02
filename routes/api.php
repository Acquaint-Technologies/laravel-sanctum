<?php

use App\Http\Controllers\Api\User\Auth\ChangePasswordController;
use App\Http\Controllers\Api\User\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\User\Auth\LoginController;
use App\Http\Controllers\Api\User\Auth\RegisterController;
use App\Http\Controllers\Api\User\Auth\ResetPasswordController;
use App\Http\Controllers\Api\User\ProfileController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function () {
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/change-password', [ChangePasswordController::class, 'change']);
        Route::post('/logout', [LoginController::class, 'logout']);
        Route::get('/me', ProfileController::class);
    });
});
