<?php

namespace App\Http\Middleware;

use App\Shareds\ResponseStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsTheOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $restaurant_id = (int) $request->route('id');

        $user = auth()->user();
        $permissions = $user->role->permissions;

        $permissionKeys = collect($permissions)->map(function ($permission) {
            return $permission['key'];
        })->toArray();

        foreach ($permissionKeys as $item) {
            if ($item === 'super-admin') {
                return $next($request);
            }
        }

        if ($restaurant_id !== $user->restaurant_id)
            return ResponseStatus::response("Cannot get in", 'Unauthorized', 401);

        return $next($request);
    }
}
