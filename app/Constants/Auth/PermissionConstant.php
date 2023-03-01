<?php

namespace App\Constants\Auth;

class PermissionConstant
{
    // IS [ROLE] PERMISSION
    const IS_SUPER_ADMIN = 'super-admin';
    const IS_ADMIN = 'admin';

    // RESTAURANT PERMISSION
    const GET_ALL_RESTAURANT = 'get-all-restaurant';
    const GET_ONE_RESTAURANT = 'get-one-restaurant';
    const UPDATE_RESTAURANT = 'update-restaurant';
    const DELETE_RESTAURANT = 'delete-restaurant';

    // TABLE PERMISSION
    const GET_ONE_TABLE = 'get-one-table';
    const GET_ALL_TABLE_BY_RESTAURANT_ID = 'get-all-table-by-restaurant-id';
    const ADD_TABLE = 'add-table';
    const UPDATE_TABLE = 'update-table';
    const DELETE_TABLE = 'delete-table';
    
    // FOOD PERMISSION
    const GET_ONE_FOOD = 'get-one-food';
    const GET_ALL_FOOD_BY_RESTAURANT_ID = 'get-all-food-by-restaurant-id';
    const ADD_FOOD = 'add-food';
    const UPDATE_FOOD = 'update-food';
    const DELETE_FOOD = 'delete-food';
    
    // TRANSACTION PERMISSION
    const GET_ONE_TRANSACTION = 'get-one-transaction';
    const GET_ONE_TRANSACTION_ON_TABLE_ID = 'get-one-transaction-on-table-id';
    const GET_ALL_TRANSACTION_BY_RESTAURANT_ID = 'get-all-transaction-by-restaurant-id';
    const ADD_TRANSACTION = 'add-transaction';
    const UPDATE_TRANSACTION = 'update-transaction';
    const DELETE_TRANSACTION = 'delete-transaction';

    // TRANSACTION PERMISSION
    const GET_ONE_ORDER = 'get-one-order';
    const GET_ALL_ORDER_BY_RESTAURANT_ID = 'get-all-order-by-restaurant-id';
    const GET_ALL_ORDER_BY_TRANSACTION_ID = 'get-all-order-by-transaction-id';
    const ADD_ORDER = 'add-order';
    const UPDATE_ORDER = 'update-order';
    const DELETE_ORDER = 'delete-order';
}
