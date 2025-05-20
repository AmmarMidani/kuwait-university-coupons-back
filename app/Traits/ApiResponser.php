<?php

namespace App\Traits;

trait ApiResponser
{
    protected function baseResponse(string $status, string $msg, int $code, array $payload = [], int $httpStatus = 200)
    {
        $response = [
            'status' => $status,
            'message' => trans($msg),
            'code' => $code,
        ];

        $response = array_merge($response, $payload);

        return response()->json($response, $httpStatus);
    }

    protected function errorResponse(int $code, string $msg, int $httpStatus = 400)
    {
        return $this->baseResponse('failed', $msg, $code, [], $httpStatus);
    }

    protected function successResponse(int $code, string $msg, int $httpStatus = 200, mixed $data = [])
    {
        return $this->baseResponse('success', $msg, $code, ['data' => $data], $httpStatus);
    }

    protected function paginatedResponse(int $code, string $msg, int $httpStatus, mixed $items, $paginator)
    {
        return $this->baseResponse('success', $msg, $code, [
            'data' => $items,
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'last_page' => $paginator->lastPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
            ],
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ], $httpStatus);
    }

    protected function ajaxErrorResponse(string $msg, mixed $data = null)
    {
        return response()->json([
            'status' => false,
            'message' => trans($msg),
            'data' => $data,
        ], 400);
    }

    protected function ajaxSuccessResponse(string $msg, mixed $data = null)
    {
        return response()->json([
            'status' => true,
            'message' => trans($msg),
            'data' => $data,
        ]);
    }
}
