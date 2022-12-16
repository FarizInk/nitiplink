<?php

namespace App\Http\Controllers\Core;

use App\Enums\CommunityRole;
use App\Http\Controllers\Controller;
use App\Models\AccountBind;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * @return Response
     */
    public function basicProfilePage(): \Inertia\Response
    {
        return Inertia::render('Profile/Basic');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateBasic(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validation = [
          'name' => 'required|string|max:255',
        ];
        if (auth()->user()->username != $request->username) {
            $validation['username'] = 'required||min:3|unique:users|string|max:255|alpha_dash';
        }
        $request->validate($validation);

        $user = User::query()->findOrFail(auth()->user()->id);
        if (auth()->user()->username != $request->username) {
            $user->username = $request->username;
        }
        $user->name = $request->name;
        $user->save();

        return redirect()->back();
    }

    /**
     * @return Response
     */
    public function changeEmailPage(): \Inertia\Response
    {
        return Inertia::render('Profile/ChangeEmail');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function updateEmail(Request $request): ?RedirectResponse
    {
        if ($request->email != auth()->user()->email) {
            $request->validate([
                'email' => 'required|email|unique:users|max:255'
            ]);

            $user = User::query()->findOrFail(auth()->user()->id);
            $user->email = $request->email;
            $user->save();

            return redirect()->back();
        }

        return null;
    }

    /**
     * @return Response
     */
    public function changePasswordPage(): \Inertia\Response
    {
        return Inertia::render('Profile/ChangePassword');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|min:8|max:255|confirmaed'
        ]);

        $user = User::query()->findOrFail(auth()->user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back();
    }

    /**
     * @return Response
     */
    public function bindProfilePage(): \Inertia\Response
    {
        $payload = AccountBind::query()->where('user_id', auth()->user()->id)->get();
        return Inertia::render('Profile/Bind', [
            'payload' => $payload,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function generateToken(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|in:discord',
        ]);

        $bind = AccountBind::query()
            ->firstOrCreate([
                'user_id' => auth()->user()->id,
                'type' => $request->type,
            ], [
                'token' => Str::random(16)
            ]);

        $bind->token = Str::random(16);
        $bind->save();

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function unbind(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|in:discord',
        ]);

        $bind = AccountBind::query()
            ->where('user_id', auth()->user()->id)
            ->where('type', $request->type)
            ->first();

        $bind?->delete();

        return redirect()->back();
    }
}
