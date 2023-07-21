<?php

namespace App\Helpers;
use Illuminate\Http\Response;

class ResponseUtils
{
    public static function successResponse($message, $data)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], 200);
    }

    public static function errorResponse($message, $data)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => $data
        ], 400);
    }

    public static function flashSuccess($message, $type = 'success')
    {
        session()->flash($type, $message);
    }

    public static function flashError($message)
    {
        self::flashSuccess($message, 'error');
    }
}