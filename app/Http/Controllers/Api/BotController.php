<?php

namespace App\Http\Controllers\Api;

use App\Enums\CommunityRole;
use App\Http\Controllers\Controller;
use App\Models\AccountBind;
use App\Models\Community;
use App\Models\CommunityUser;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BotController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        $request->validate([
            'prefix' => 'required|string',
            'user_id' => 'required|string', // discord user id
        ]);

        $community = Community::query()->where('prefix', str_replace("@", "", $request->prefix))->first();
        if (!$community) {
            return $this->responseJSON(false, message: "community prefix not found!", code: 422);
        }

        $checkBind = AccountBind::query()
            ->where('type', 'discord')
            ->where('bind_credential', $request->user_id)
            ->first();
        if (!$checkBind) {
            return $this->responseJSON(data: false, message: "your account not binded! please bind before add link.", code: 422);
        }

        $userCommunity = CommunityUser::query()
            ->where('user_id', $checkBind->user_id)
            ->where('community_id', $community->id)
            ->first();

        $havePermission = in_array($userCommunity?->role, [CommunityRole::Owner->value, CommunityRole::Moderator->value, CommunityRole::Contributor->value]);
        if (!$havePermission) {
            return $this->responseJSON(false, message: "you don't have permission to add link, please contact community Owner or Moderator", code: 422);
        }

        return $this->responseJSON(data: true, message: 'Success checking credential account & parameter.');
    }

    public function bindAccount(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'token' => 'required|string',
            'user_id' => 'required|string', // discord user id
        ]);

        $bind = AccountBind::query()
            ->where('type', 'discord')
            ->where('token', $request->token)
            ->first();

        if ($bind) {
            $bind->bind_credential = $request->user_id;
            $bind->binded_at = Carbon::now();
            $bind->save();

            $bind->load('user');

            return $this->responseJSON(data: [], message: 'your discord account successfully binded to ' . $bind->user->name . ' (' . $bind->user->username . ')');
        }

        return $this->responseJSON(data: [], message: 'token not found!', code: 404);
    }

    public function createLink(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->responseJSON();
    }
}
