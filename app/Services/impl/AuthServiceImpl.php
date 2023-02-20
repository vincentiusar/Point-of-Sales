<?php

namespace App\Services\impl;

use App\Services\AuthService;

class AuthServiceImpl implements AuthService
{

    public function validateUser($username, $pass) {

    }

    public function login($username, $pass) {
        return 'ok';
    }

    public function signup($user) {
        
    }

    public function logout() {

    }
}