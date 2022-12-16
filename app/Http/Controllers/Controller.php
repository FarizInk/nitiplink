<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static function responseJSON($data = null, $message = null, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'payload' => $data,
            'message' => $message,
        ], $code);
    }
}
