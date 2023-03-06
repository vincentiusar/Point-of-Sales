<?php

namespace App\Http\Middleware;

use App\Models\Table;
use App\Shareds\ResponseStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CompareTableSession
{

    public function __construct(
        private Table $table,
    )
    {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $table = $this->table->where('id', (int) $request->route('id'))->first();

        if (auth()->user()->role_id == 4 && $table->session_id != JWTAuth::getToken()) {
            return ResponseStatus::response("Cannot get in", 'Unauthorized', 401);
        }

        return $next($request);
    }
}
