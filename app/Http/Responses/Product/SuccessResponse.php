<?php

namespace App\Http\Responses\Product;

use Illuminate\Http\JsonResponse;

class SuccessResponse
{
    /**
     * @param $response
     * @return JsonResponse
     */
    public static function response($response): JsonResponse
    {
        return response()->json([
            'products' => $response,
            'status' => true
        ], 200);
    }
}
