<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthLoginResource;
use App\Http\Resources\Auth\AuthMeResource;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\Auth\AuthService;
use Error;
use Illuminate\Http\Request;
use App\Shareds\ResponseStatus;

class UserAuthController extends Controller
{

    public function __construct(
        private Restaurant $restaurant,
        private User $user,
        private AuthService $authService,
    )
    {
    }

    /**
     * Function to log in
     * 
     * @param LoginRequest $request
     * @return ResponseStatus
     */
    public function login(LoginRequest $request) {
        try {
            $data = $this->authService->login($request->username, $request->password);

            return ResponseStatus::response(new AuthLoginResource($data?->data), $data->status, $data->statusCode);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }


    /**
     * Function to get user base on token
     * 
     * @param
     * @return ResponseStatus
     */
    public function me() {
        try {
            return ResponseStatus::response(new AuthMeResource(auth()->user()));
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    /**
     * Function to log out
     * 
     * @param
     * @return ResponseStatus
     */
    public function logout() {
        try {
            $this->authService->logout();

            return ResponseStatus::response(null);
        } catch (Error $err) {
            return ResponseStatus::response(['Message' => $err->getMessage()], 'Server Internal Error', 500);
        }
    }

    public function test(Request $request)
    {
        return ResponseStatus::response('hai');
    }
}
