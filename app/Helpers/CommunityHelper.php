<?php

namespace App\Helpers;

use App\Models\Community;
use App\Models\CommunityUser;

class CommunityHelper
{
    static function getBaseData($prefix): array
    {

        $community = Community::query()->where('prefix', str_replace("@", "", $prefix))->first();
        $communityRole = auth()->check() ? CommunityUser::query()->where('user_id', auth()->user()->id)->where('community_id', $community->id)->first() : null;
        return [
            'community' => $community,
            'user_community_role' => $communityRole?->value('role'),
        ];
    }
}
