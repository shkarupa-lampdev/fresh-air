<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @param mixed $message
     * @param mixed $result
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($message, $result = [])
    {
        $response = [
            'success' => true,
            'message' => $message,
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param mixed $error
     * @param mixed $errorMessages
     * @param mixed $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages['error'];
        }

        return response()->json($response, $code);
    }
}
