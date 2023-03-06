<?php

namespace App\Shareds;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ResponseStatus
{
    /**
     * Response json success
     *
     * @param mixed $data 
     * @param string $status
     * @param int $statusCode
     * @return JsonResponse
     */
    public static function response(mixed $data, ?string $status = 'success', ?int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $status ?? 'success',
            'statusCode' => $statusCode ?? 200,
            'data' => $data ?? null,
        ], $statusCode);
    }
}
