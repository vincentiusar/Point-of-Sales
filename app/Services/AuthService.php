<?php

namespace App\Services;

interface AuthService
{
    public function login($username, $pass);
    public function logout();
}