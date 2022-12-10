<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Webhook;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    /**
     * @return Response
     */
    public function indexPage(): Response
    {
        return Inertia::render('Community/Setting/Index');
    }

    /**
     * @return Response
     */
    public function overviewPage(): \Inertia\Response
    {
        return Inertia::render('Community/Setting/Overview');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function followerPage(Request $request): \Inertia\Response
    {
        $prefix = $request->prefix;
        $users = User::query()
            ->whereHas('communities', function ($query) use ($prefix) {
                $query->where('prefix', str_replace("@", "", $prefix));
            })
            ->with('communities', function ($query) use ($prefix) {
                $query->where('prefix', str_replace("@", "", $prefix));
            })
            ->paginate(10);

        return Inertia::render('Community/Setting/Follower', [
            'followers' => $users,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function webhookPage(Request $request): \Inertia\Response
    {
        $prefix = $request->prefix;
        $webhooks = Webhook::query()
            ->whereHas('community', function ($query) use ($prefix) {
                $query->where('prefix', str_replace("@", "", $prefix));
            })
            ->paginate(10);

        return Inertia::render('Community/Setting/Webhook', [
            'webhooks' => $webhooks,
        ]);
    }
}
