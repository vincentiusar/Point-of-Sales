<?php

namespace App\Services\Auth\impl;

use App\Models\User;
use App\Services\Auth\AuthService;
use App\Shareds\BaseService;

class AuthServiceImpl extends BaseService implements AuthService
{

    public function __construct(private readonly User $user)
    {
        parent::__construct($user);
    }

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