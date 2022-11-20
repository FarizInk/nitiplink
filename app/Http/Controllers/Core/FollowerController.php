<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function get($community_hash): \Illuminate\Http\JsonResponse
    {
        $community = Community::byHash($community_hash);
        $community->load('users');
        return response()->json($community->users);
    }

    public function update(Request $request, $community_hash)
    {
        $community = Community::byHash($community_hash);
        $user = User::byHash($request->hash);

        if ($community && $user) {
            $community->users()->updateExistingPivot($user->id, ['role' => $request->role], false);
        }
    }
}
