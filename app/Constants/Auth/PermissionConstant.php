<?php

namespace App\Constants\Auth;

class PermissionConstant
{
    // IS [ROLE] PERMISSION
    const IS_SUPER_ADMIN = 'super-admin';   // 1
    const IS_ADMIN = 'admin';               // 2

    // RESTAURANT PERMISSION
    const GET_ALL_RESTAURANT = 'get-all-restaurant';    // 3
    const GET_ONE_RESTAURANT = 'get-one-restaurant';    // 4
    const UPDATE_RESTAURANT = 'update-restaurant';      // 5
    const DELETE_RESTAURANT = 'delete-restaurant';      // 6

    // TABLE PERMISSION
    const GET_ONE_TABLE = 'get-one-table';              // 7
    const GET_ALL_TABLE_BY_RESTAURANT_ID = 'get-all-table-by-restaurant-id';    // 8
    const ADD_TABLE = 'add-table';                      // 9
    const UPDATE_TABLE = 'update-table';                // 10
    const DELETE_TABLE = 'delete-table';                // 11
    
    // FOOD PERMISSION
    const GET_ONE_FOOD = 'get-one-food';                // 12
    const GET_ALL_FOOD_BY_RESTAURANT_ID = 'get-all-food-by-restaurant-id';      // 13
    const ADD_FOOD = 'add-food';            // 14
    const UPDATE_FOOD = 'update-food';      // 15
    const DELETE_FOOD = 'delete-food';      // 16
    
    // TRANSACTION PERMISSION
    const GET_ONE_TRANSACTION = 'get-one-transaction';      // 17
    const GET_ONE_TRANSACTION_ON_TABLE_ID = 'get-one-transaction-on-table-id';  // 18
    const GET_ALL_TRANSACTION_BY_RESTAURANT_ID = 'get-all-transaction-by-restaurant-id';   // 19
    const ADD_TRANSACTION = 'add-transaction';  // 20
    const PAYMENT = 'payment';                  // 21
    const UNDO_PAYMENT = 'undo-payment';        // 22
    const DELETE_TRANSACTION = 'delete-transaction';    // 23

    // TRANSACTION PERMISSION
    const GET_ONE_ORDER = 'get-one-order';      // 24
    const GET_ALL_ORDER_BY_RESTAURANT_ID = 'get-all-order-by-restaurant-id';        // 25
    const GET_ALL_ORDER_BY_TRANSACTION_ID = 'get-all-order-by-transaction-id';      // 26
    const ADD_ORDER = 'add-order';              // 27
    const UPDATE_ORDER = 'update-order';        // 28
    const DELETE_ORDER = 'delete-order';        // 29
}
