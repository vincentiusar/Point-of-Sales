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
    const ADD_TABLE = 'add-table';
}
