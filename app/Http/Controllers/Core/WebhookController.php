<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Webhook;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function get(Community $community): \Illuminate\Http\JsonResponse
    {
        $webhooks = Webhook::query()->where('community_id', $community->id)->get();
        return response()->json($webhooks);
    }

    public function create(Request $request, Community $community)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required|url',
        ]);

        $webhook = new Webhook();
        $webhook->community_id = $community->id;
        $webhook->name = $request->name;
        $webhook->type = 'discord';
        $webhook->url = $request->url;
        $webhook->save();

        return redirect()->back();
    }

    public function delete(Community $community, Webhook $webhook): \Illuminate\Http\RedirectResponse
    {
        if ($community->id === $webhook->community_id) {
            $webhook->delete();
        }

        return redirect()->back();
    }
}
