<?php

namespace App\Http\Services;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ResponseService {

    public function successResponse($data, $statusCode = ResponseAlias::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $statusCode);
    }

    public function errorResponse($message, $statusCode = ResponseAlias::HTTP_BAD_GATEWAY , $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);

    }

}
