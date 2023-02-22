<?php

namespace App\Services\impl;

use App\Services\AuthService;

class AuthServiceImpl implements AuthService
{
    public function login($username, $pass) {
        $credentials = ['username' => $username, 'password' => $pass];
        
        $token = auth('api')->attempt($credentials);
        if (!$token)
            return (object) ['data' => 'Unauthorized', 'status' => 'Unauthorized', 'statusCode' => 401];

        return (object) [
            'data' => [
                'token' => $token
            ],
            'status' => "success",
            'statusCode' => 200,
        ];
    }

    public function logout() {
        auth()->logout();

        return (object) [
            'data' => null,
            'status' => "success",
            'statusCode' => 200
        ];
    }
}