<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'remember' => 'required|boolean',
        ]);

        $credential = ['username' => $request->username, 'password' => $request->password];
        if(filter_var($request->username, FILTER_VALIDATE_EMAIL))
        {
            $credential = ['email' => $request->username, 'password' => $request->password];
        }

        if (Auth::attempt($credential, $request->remember)) {
            return redirect()->back();
        }

        return redirect()->back()->withErrors(['username' => 'Credential not found.']);
    }

    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'username' => 'required|min:3|unique:users|string|max:255|alpha_dash',
            'password' => 'required|min:8|max:255'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::loginUsingId($user->id);

        return redirect()->back();
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        return redirect()->back();
    }
}
