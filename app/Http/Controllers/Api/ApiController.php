<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller {

    protected function successResponse($data, $message = null, $status = 200) {
        return response()->json([
                    'success' => 1,
                    'message' => $message ?: 'success',
                    'data' => $data
                        ], $status);
    }

    protected function failedResponse($data, $message = null, $status = 200) {
        return response()->json([
                    'success' => 0,
                    'message' => $message ?: 'failure',
                    'data' => $data
                        ], $status);
    }
}
