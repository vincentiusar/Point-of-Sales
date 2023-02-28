<?php

use App\Constants\Auth\PermissionConstant;
use App\Http\Controllers\auth\UserAuthController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\Table\TableController;
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

Route::get('/test', );

Route::middleware(['cors', 'json.response'])->group(function () {    
    Route::post('/login', [UserAuthController::class, 'login']);
});

Route::middleware(['cors', 'json.response', 'auth:api'])->group(function () {
    Route::delete('/logout', [UserAuthController::class, 'logout']);
    Route::get('/me', [UserAuthController::class, 'me']);
    
    Route::group(['prefix' => '/restaurant'], function () {
        Route::get('/my', [RestaurantController::class, 'showByToken']);

        // PURE RESTAURANT REQUEST
        Route::middleware(['permission:' . PermissionConstant::GET_ALL_RESTAURANT . '|' . PermissionConstant::IS_SUPER_ADMIN])->get('/', [RestaurantController::class, 'index']);
        Route::middleware(['permission:' . PermissionConstant::GET_ONE_RESTAURANT, 'is_the_owner'])->get('/{restaurant_id}', [RestaurantController::class, 'show']);
        Route::middleware(['permission:' . PermissionConstant::UPDATE_RESTAURANT])->put('/update', [RestaurantController::class, 'updateByToken']);
        Route::middleware(['permission:' . PermissionConstant::UPDATE_RESTAURANT . '|' . PermissionConstant::IS_SUPER_ADMIN, 'is_the_owner'])->put('/update/{restaurant_id}', [RestaurantController::class, 'updateById']);
        Route::middleware(['permission:' . PermissionConstant::DELETE_RESTAURANT . '|' . PermissionConstant::IS_SUPER_ADMIN, 'is_the_owner'])->delete('/delete/{restaurant_id}', [RestaurantController::class, 'delete']);
    
        // RESTAURANT TABLE REQUEST
        
        Route::group(['prefix' => '/{restaurant_id}/table'], function () {
            Route::middleware(['permission:' . PermissionConstant::GET_ALL_TABLE_BY_RESTAURANT_ID, 'is_the_owner'])->get('/', [TableController::class, 'getAllByRestaurantID']);
            Route::middleware(['permission:' . PermissionConstant::GET_ONE_TABLE, 'is_the_owner'])->get('/{id}', [TableController::class, 'show']);
            Route::middleware(['permission:' . PermissionConstant::ADD_TABLE, 'is_the_owner'])->post('/add', [TableController::class, 'create']);
            Route::middleware(['permission:' . PermissionConstant::UPDATE_TABLE, 'is_the_owner'])->put('/update/{id}', [TableController::class, 'update']);
            Route::middleware(['permission:' . PermissionConstant::DELETE_TABLE, 'is_the_owner'])->delete('/delete/{id}', [TableController::class, 'delete']);
        });

        Route::group(['prefix' => '/{restaurant_id}/food'], function () {
            Route::middleware('permission:' . PermissionConstant::GET_ALL_FOOD_BY_RESTAURANT_ID, 'is_the_owner')->get('/', [FoodController::class, 'getAllByRestaurantID']);
            Route::middleware('permission:' . PermissionConstant::GET_ONE_FOOD, 'is_the_owner')->get('/{id}', [FoodController::class, 'show']);
            Route::middleware('permission:' . PermissionConstant::ADD_FOOD, 'is_the_owner')->post('/add', [FoodController::class, 'create']);
            Route::middleware('permission:' . PermissionConstant::UPDATE_FOOD, 'is_the_owner')->put('/update/{id}', [FoodController::class, 'update']);
            Route::middleware('permission:' . PermissionConstant::DELETE_FOOD, 'is_the_owner')->delete('/delete/{id}', [FoodController::class, 'delete']);
        });
    });
    
    Route::group(['prefix' => '/table'], function () {
        Route::middleware(['permission:' . PermissionConstant::IS_SUPER_ADMIN])->get('/', [TableController::class, 'index']);
    });

    Route::group(['prefix' => '/food'], function () {
        Route::middleware(['permission:' . PermissionConstant::IS_SUPER_ADMIN])->get('/', [FoodController::class, 'index']);
    });
});