<?php

namespace App\Traits;

trait ApiResponser
{
    protected function errorResponse($code, $msg, $status)
    {
        $response = [
            'status' => 'failed',
            'message' => trans($msg),
            'code' => $code,
        ];
        return response()->json($response, $status);
    }

    protected function successResponse($code, $msg, $status, $data = [])
    {
        $response = [
            'status' => 'success',
            'message' => trans($msg),
            'code' => $code,
            'data' => $data,
        ];
        return response()->json($response, $status);
    }

    protected function ajaxErrorResponse($msg, $data = null)
    {
        return response()->json([
            'status' => false,
            'message' => trans($msg),
            'data' => $data,
        ], 400);
    }

    protected function ajaxSuccessResponse($msg, $data = null)
    {
        return response()->json([
            'status' => true,
            'message' => trans($msg),
            'data' => $data,
        ]);
    }
}
