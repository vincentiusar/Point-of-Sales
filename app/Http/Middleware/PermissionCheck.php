<?php

namespace App\Http\Middleware;

use App\Models\RolePermission;
use App\Shareds\ResponseStatus;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @param string $permissionKey
     * @return void|\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws ForbiddenException
     */
    public function handle(Request $request, \Closure $next, string $permissionKey)
    {
        $permissionsArray = explode('|', $permissionKey);
        $user_role = Auth::user()->role_id;
        $permissions = RolePermission::with('permission')->where('role_id', $user_role)->get()->toArray();
        $permissionKeys = collect($permissions)->map(function ($permission) {
            return $permission['permission']['key'];
        })->toArray();

        foreach ($permissionsArray as $item) {
            if (in_array($item, $permissionKeys)) {
                return $next($request);
            }

            return ResponseStatus::response("Cannot get in", 'Unauthorized', 401);
        }
    }
}
