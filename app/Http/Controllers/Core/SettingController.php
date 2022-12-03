<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Setting/Index', [
            'Setting' => null,
        ]);
    }
}
