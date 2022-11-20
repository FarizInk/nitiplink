<?php

namespace App\Http\Controllers\Core;

use App\Enums\CommunityRole;
use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function get(): \Illuminate\Http\JsonResponse
    {
        $communities = Community::query()->whereHas('users', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();

        return response()->json($communities);
    }

    public function follow($community_hash)
    {
        $community = Community::byHash($community_hash);
        $community->users()->attach(auth()->user()->id, [
            'role' => $community->created_by === auth()->user()->id ? CommunityRole::Owner : CommunityRole::Follower,
        ]);
    }

    public function unfollow($community_hash): \Illuminate\Http\RedirectResponse
    {
        $community = Community::byHash($community_hash);
        $community->users()->detach(auth()->user()->id);

        return redirect()->back();
    }

    public function create(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => ['required', 'string', 'max:255', 'unique:communities', 'alpha_dash'],
        ]);

        $userId = auth()->user()->id;
        $community = new Community();
        $community->name = $request->name;
        $community->prefix = $request->prefix;
        $community->created_by = $userId;
        $community->save();

        $community->users()->attach($userId, [
            'role' => CommunityRole::Owner,
        ]);

        return redirect()->back();
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
