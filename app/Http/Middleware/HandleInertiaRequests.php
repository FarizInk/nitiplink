<?php

namespace App\Http\Middleware;

use App\Models\Community;
use App\Models\CommunityUser;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        $communityData = [];
        if ($request->prefix) {
            $community = Community::query()->where('prefix', str_replace("@", "", $request->prefix))->first();
            $communityRole = auth()->check() ? CommunityUser::query()->where('user_id', auth()->user()->id)->where('community_id', $community->id)->first() : null;
            $communityData =  [
                'community' => $community,
                'user_community_role' => $communityRole?->value('role'),
            ];
        }
        return array_merge(parent::share($request), [
            'auth.user' => fn () => $request->user() ? $request->user() : null,
        ], $communityData);
    }
}
