<?php

use App\Constants\Auth\PermissionConstant;
use App\Http\Controllers\auth\UserAuthController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\User\UserController;
use App\Models\Restaurant;
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

Route::get('/test', function() {
    
});

Route::middleware(['cors', 'json.response'])->group(function () {    
    Route::post('/login', [UserAuthController::class, 'login']);
});

Route::middleware(['cors', 'json.response', 'auth:api'])->group(function () {
    Route::delete('/logout', [UserAuthController::class, 'logout']);
    Route::get('/me', [UserAuthController::class, 'me']);
    
    Route::group(['prefix' => '/table'], function () {
        Route::middleware('permission:' . PermissionConstant::ADD_TABLE)->post('/add', [UserAuthController::class, 'test']);
    });
    
    Route::group(['prefix' => '/restaurant'], function () {
        Route::get('/my', [RestaurantController::class, 'showByToken']);

        Route::middleware(['permission:' . PermissionConstant::GET_ALL_RESTAURANT . '|' . PermissionConstant::IS_SUPER_ADMIN])->get('/', [RestaurantController::class, 'index']);
        Route::middleware(['permission:' . PermissionConstant::GET_ONE_RESTAURANT, 'is_the_owner'])->get('/{id}', [RestaurantController::class, 'show']);
        Route::middleware(['permission:' . PermissionConstant::UPDATE_RESTAURANT, 'is_the_owner'])->put('/update', [RestaurantController::class, 'updateByToken']);
        Route::middleware(['permission:' . PermissionConstant::UPDATE_RESTAURANT . '|' . PermissionConstant::IS_SUPER_ADMIN])->put('/update/{id}', [RestaurantController::class, 'updateById']);
        Route::middleware(['permission:' . PermissionConstant::DELETE_RESTAURANT . '|' . PermissionConstant::IS_SUPER_ADMIN])->delete('/delete/{id}', [RestaurantController::class, 'delete']);
    });
});