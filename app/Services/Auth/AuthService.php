<?php

namespace App\Services\Auth;

interface AuthService
{
    public function login($username, $pass);
    public function logout();
}