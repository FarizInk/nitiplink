<?php

namespace App\Enums;

enum CommunityRole: string
{
    case Owner = 'owner';
    case Moderator = 'moderator';
    case Contributor = 'contributor';
    case Follower = 'follower';
}
