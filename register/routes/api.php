<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
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
/* Un authenticated */
Route::get('clients', [ClientController::class, 'index']);
Route::post('clients', [ClientController::class, 'store']);

Route::middleware(['auth:api'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::group(['prefix' => 'clients', 'as' => 'clients.'], function () {
            Route::get('/{id}', [ClientController::class, 'show']);
            Route::get('', [ClientController::class, 'index']);
            Route::post('', [ClientController::class, 'store']);
        });
    });
});
