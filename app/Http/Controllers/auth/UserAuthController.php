<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{

    public function __construct(
        private Restaurant $restaurant,
        private User $user,
    )
    {
    }

    public function test()
    {
        $data = $this->user
                ->with('restaurant.tables')
                ->get();

        return response($data, 200);
    }
}
