<?php

use App\Constants\Auth\PermissionConstant;
use App\Http\Controllers\auth\UserAuthController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\Table\TableController;
use App\Http\Controllers\Transaction\TransactionController;
use App\Models\User;
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
    $img = app('firebase.storage')->getBucket()->object("images/leblanc.jpg");

    $expiresAt = new \DateTime('tomorrow');
    if ($img->exists()) {
        $img = $img->signedUrl($expiresAt);
    } else {
        $img = null;
    }

    return response($img, 200);
});

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

            // TRANSACTION ON GOING ON TABLE {ID}
            Route::middleware(['permission:' . PermissionConstant::GET_ONE_TRANSACTION_ON_TABLE_ID, 'is_the_owner'])->get('/{id}/transaction', [TransactionController::class, 'activeTransactionOnTable']);
        });

        Route::group(['prefix' => '/{restaurant_id}/food'], function () {
            // Customer
            Route::middleware('permission:' . PermissionConstant::GET_ALL_FOOD_BY_RESTAURANT_ID, 'is_the_owner')->get('/', [FoodController::class, 'getAllByRestaurantID']);
            Route::middleware('permission:' . PermissionConstant::GET_ONE_FOOD, 'is_the_owner')->get('/{id}', [FoodController::class, 'show']);
            Route::middleware('permission:' . PermissionConstant::GET_ALL_FOOD_BY_RESTAURANT_ID, 'is_the_owner')->post('/many', [FoodController::class, 'showMultiple']);

            Route::middleware('permission:' . PermissionConstant::ADD_FOOD, 'is_the_owner')->post('/add', [FoodController::class, 'create']);
            Route::middleware('permission:' . PermissionConstant::UPDATE_FOOD, 'is_the_owner')->put('/update/{id}', [FoodController::class, 'update']);
            Route::middleware('permission:' . PermissionConstant::DELETE_FOOD, 'is_the_owner')->delete('/delete/{id}', [FoodController::class, 'delete']);
        });

        // ALL ORDER IN RESTAURANT
        Route::group(['prefix' => '/{restaurant_id}/order'], function () {
            Route::middleware('permission:' . PermissionConstant::GET_ALL_ORDER_BY_RESTAURANT_ID, 'is_the_owner')->get('/', [OrderController::class, 'getAllByRestaurantID']);
            Route::middleware('permission:' . PermissionConstant::GET_ONE_ORDER, 'is_the_owner')->get('/{id}', [OrderController::class, 'show']);
        });

        Route::group(['prefix' => '/{restaurant_id}/transaction'], function () {
            Route::middleware('permission:' . PermissionConstant::GET_ALL_TRANSACTION_BY_RESTAURANT_ID, 'is_the_owner')->get('/', [TransactionController::class, 'getAllByRestaurantID']);
            Route::middleware('permission:' . PermissionConstant::GET_ONE_TRANSACTION, 'is_the_owner')->get('/{id}', [TransactionController::class, 'show']);
            Route::middleware('permission:' . PermissionConstant::ADD_TRANSACTION, 'is_the_owner')->post('/add', [TransactionController::class, 'create']);
            Route::middleware('permission:' . PermissionConstant::ADD_TRANSACTION, 'is_the_owner')->post('/refresh', [TransactionController::class, 'refreshToken']);
            Route::middleware('permission:' . PermissionConstant::PAYMENT, 'is_the_owner')->put('/payment/{id}', [TransactionController::class, 'payment']);
            Route::middleware('permission:' . PermissionConstant::UNDO_PAYMENT, 'is_the_owner')->put('/undopayment/{id}', [TransactionController::class, 'undoPayment']);
            Route::middleware('permission:' . PermissionConstant::DELETE_TRANSACTION, 'is_the_owner')->delete('/delete/{id}', [TransactionController::class, 'delete']);

            Route::group(['prefix' => '/{transaction_id}/order'], function () {
                // Customer
                Route::middleware('permission:' . PermissionConstant::GET_ALL_ORDER_BY_TRANSACTION_ID, 'is_the_owner')->get('/', [OrderController::class, 'getAllByTransactionID']);
                Route::middleware('permission:' . PermissionConstant::ADD_ORDER, 'is_the_owner')->post('/add', [OrderController::class, 'create']);

                Route::middleware('permission:' . PermissionConstant::UPDATE_ORDER, 'is_the_owner')->put('/update', [OrderController::class, 'update']);
                Route::middleware('permission:' . PermissionConstant::DELETE_ORDER, 'is_the_owner')->delete('/delete/{id}', [OrderController::class, 'delete']);
            });
        });

    });
    
    Route::group(['prefix' => '/table'], function () {
        Route::middleware(['permission:' . PermissionConstant::IS_SUPER_ADMIN])->get('/', [TableController::class, 'index']);
    });

    Route::group(['prefix' => '/food'], function () {
        Route::middleware(['permission:' . PermissionConstant::IS_SUPER_ADMIN])->get('/', [FoodController::class, 'index']);
    });

    Route::group(['prefix' => '/transaction'], function () {
        Route::middleware(['permission:' . PermissionConstant::IS_SUPER_ADMIN])->get('/', [TransactionController::class, 'index']);
    });

    Route::group(['prefix' => '/order'], function () {
        Route::middleware(['permission:' . PermissionConstant::IS_SUPER_ADMIN])->get('/', [OrderController::class, 'index']);
    });
});