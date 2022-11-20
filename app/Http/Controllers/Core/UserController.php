<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function data(): \Illuminate\Http\JsonResponse
    {
        return response()->json(auth()->user());
    }

    public function changeEmail()
    {

    }

    public function changeUsername()
    {

    }

    public function changePassword()
    {

    }
}
