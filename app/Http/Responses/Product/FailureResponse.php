<?php

namespace App\Http\Responses\Product;

use Illuminate\Http\JsonResponse;

class FailureResponse
{
    /**
     * @param $errors
     * @return JsonResponse
     */
    public static function handleValidation($errors): JsonResponse
    {
        return response()->json(
            array_merge([
                'status'=> false,
            ], $errors),
            422);
    }

    /**
     * @param string $errorMessage
     * @return JsonResponse
     */
    public static function handleException(string $errorMessage): JsonResponse
    {
        $response = [
            'message' => 'Something went wrong. We have recorded this incident, and please try again later.',
            'errorMessage'=> $errorMessage
        ];

        return response()->json($response, 500);
    }

}
