<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{

    public function __construct(
        private Restaurant $restaurant,
        private User $user,
        private AuthService $authService,
    )
    {
    }

    public function test(Request $request)
    {
        // $response = $this->authService->login(request(['username']), request(['password']));

        // return response()->json($response);
        
        // $credentials = request(['username', 'password']);

        // $token = auth('api')->attempt($credentials);
        // if (!$token) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return response(['token' => $token], 200);
        
        return response()->json(auth()->user());

        // $data = $this->user
        //         ->with('restaurant.tables')
        //         ->get();

        // return response($data, 200);
    }
}
