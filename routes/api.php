<?php

use App\Constants\Auth\PermissionConstant;
use App\Http\Controllers\auth\UserAuthController;
use App\Http\Controllers\User\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test', [UserAuthController::class, 'test']);

Route::middleware(['cors', 'json.response'])->group(function () {    
    Route::post('/login', [UserAuthController::class, 'login']);
});

Route::middleware(['cors', 'json.response', 'auth:api'])->group(function () {
    Route::delete('/logout', [UserAuthController::class, 'logout']);
    Route::get('/me', [UserAuthController::class, 'me']);

    Route::group(['prefix' => '/table'], function () {
        Route::middleware('permission:' . PermissionConstant::ADD_TABLE)->post('/add', [UserAuthController::class, 'test']);
    });
});