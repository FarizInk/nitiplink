<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Webhook;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function get($community_hash)
    {
        $webhooks = Webhook::query()->where('community_id', Community::hashToId($community_hash))->get();
        return response()->json($webhooks);
    }

    public function create(Request $request, $community_hash)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|url',
        ]);

        $communityId = Community::hashToId($community_hash);

        $webhook = new Webhook();
        $webhook->community_id = $communityId;
        $webhook->name = $request->name;
        $webhook->type = 'discord';
        $webhook->url = $request->url;
        $webhook->save();

        return redirect()->back();
    }

    public function delete($community_hash, $hash): \Illuminate\Http\RedirectResponse
    {
        $webhook = Webhook::byHash($hash);
        $webhook->delete();

        return redirect()->back();
    }
}
