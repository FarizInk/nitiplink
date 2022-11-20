<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityUser;
use App\Models\Link;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppController extends Controller
{
    public function index($prefix): \Inertia\Response|\Inertia\ResponseFactory
    {
        if ($prefix[0] === '@') {
            $community = Community::query()->where('prefix', str_replace("@", "", $prefix))->first();
            if (!$community) return inertia('404');

            $links = Link::query()->where('community_id', $community->id)->with(['creator', 'tags'])->orderBy('created_at', 'desc')->get();
            $communityRole = auth()->check() ? CommunityUser::query()->where('user_id', auth()->user()->id)->where('community_id', $community->id)->first() : null;
            return Inertia::render('App', [
                'community' => $community,
                'links' => $links,
                'user_community_role' => $communityRole?->value('role'),
            ]);
        } else {
            return inertia('404');
        }
    }
}
