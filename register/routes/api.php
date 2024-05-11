<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('/{id}', [UserController::class, 'show']);
            Route::get('', [UserController::class, 'index']);
            Route::post('', [UserController::class, 'store']);
        });
    });
});
