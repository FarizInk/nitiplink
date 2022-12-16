<?php

namespace App\Http\Controllers\Core;

use App\Enums\CommunityRole;
use App\Helpers\CommunityHelper;
use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityUser;
use App\Models\Link;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommunityController extends Controller
{
    public function indexPage($prefix): \Inertia\Response|\Inertia\ResponseFactory
    {
        $baseData = CommunityHelper::getBaseData($prefix);
        $links = Link::query()->where('community_id', $baseData['community']->id)->with(['creator', 'tags'])->orderBy('created_at', 'desc')->get();
        return Inertia::render('Community/Index', [
            'links' => $links,
        ]);
    }

    public function get(): \Illuminate\Http\JsonResponse
    {
        $communities = Community::query()->whereHas('users', function ($query) {
            $query->where('user_id', auth()->user()->id);
        })->get();

        return response()->json($communities);
    }

    public function follow(Community $community)
    {
        $community->users()->attach(auth()->user()->id, [
            'role' => $community->created_by === auth()->user()->id ? CommunityRole::Owner : CommunityRole::Follower,
        ]);
    }

    public function unfollow(Community $community): \Illuminate\Http\RedirectResponse
    {
        $community->users()->detach(auth()->user()->id);

        return redirect()->back();
    }

    public function create(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => ['required', 'string', 'min:3', 'max:255', 'unique:communities', 'alpha_dash'],
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
