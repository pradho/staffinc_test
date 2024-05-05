<?php

namespace App;

trait ApiResponseTrait
{
    /**
     * Send any success response.
     *
     * @param mixed $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data = null, int $code = 200)
    {
        return response()->json(['data' => $data], $code);
    }

    /**
     * Send any error response.
     *
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse(string $message, int $code)
    {
        return response()->json(['error' => $message], $code);
    }

    /**
     * Send any validation error response.
     *
     * @param array $errors
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function validationErrorResponse(array $errors, int $code = 422)
    {
        return response()->json(['errors' => $errors], $code);
    }
}
