<?php

namespace App\Http\Controllers\Core;

use App\Helpers\CommunityHelper;
use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Link;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class LinkController extends Controller
{
    public function detailPage($prefix, $link_hash): \Inertia\Response|\Inertia\ResponseFactory
    {
        return Inertia::render('Community/DetailLink', [
            'link' => Link::byHash($link_hash)?->load(['creator', 'tags']),
        ]);
    }

    private function validation(): array
    {
        return [
            'url' => 'required|url',
            'note' => 'nullable',
            'tags' => 'array',
        ];
    }

    private function firstOrCreate($tags)
    {
        $data = [];
        foreach ($tags as $tag) {
            $tag = Tag::query()->firstOrCreate([
                'name' => strtolower($tag),
            ]);
            $data[] = $tag->id;
        }

        return $data;
    }

    public function create(Request $request, Community $community): \Illuminate\Http\RedirectResponse
    {
        $request->validate($this->validation());

        $link = new Link();
        $link->url = $request->url;
        $link->note = $request->note;
        $link->created_by = auth()->user()->id;
        $link->updated_by = auth()->user()->id;
        $link->community_id = $community->id;
        $link->save();

        $link->tags()->sync($this->firstOrCreate($request->tags));

        $community->load("webhooks");
        foreach ($community->webhooks as $webhook) {
            $this->sendWebhook(
                $webhook->url,
                auth()->user()->name . " added new link!",
                $request->url,
                $request->note,
                $request->tags,
                $community->name,
                $community->prefix,
                auth()->user()->name,
                $link->created_at
            );
        }

        return redirect()->back();
    }

    public function update(Request $request, Community $community, Link $link): \Illuminate\Http\RedirectResponse
    {
        $request->validate($this->validation());
        $link->url = $request->url;
        $link->note = $request->note;
        $link->updated_by = auth()->user()->id;
        $link->save();

        $link->tags()->sync($this->firstOrCreate($request->tags));

        return redirect()->back();
    }

    public function delete(Community $community, Link $link): \Illuminate\Http\RedirectResponse
    {
        if ($community->id === $link->community_id) {
            $link->delete();
        }

        return redirect()->route('app.community.index', '@' . $community->prefix);
    }

    public function sendWebhook($url, $content, $title, $description, $tags, $communityName, $communityPrefix, $userName, $createdAt): bool|string
    {
        $data = [
            "content" => $content,
            "embeds" => [
                [
                    "title" => $title,
                    "description" => $description,
                    "color" => 5261029,
                    "fields" => [
                        [
                            "name" => "Tags",
                            "value" => count($tags) >= 1 ? implode(", ", $tags) : "`no tags.`",
                        ],
                    ],
                    "author" => [
                        "name" => $communityName,
                        "url" => URL::to('/@' . $communityPrefix),
                        "icon_url" => "https://ui-avatars.com/api/?name=" . urlencode($communityName) . "&background=5046e5&color=fff",
                    ],
                    "footer" => [
                        "text" => $userName,
                        "icon_url" => "https://ui-avatars.com/api/?name=" . urlencode($userName) . "&background=5046e5&color=fff",
                    ],
                    "timestamp" => Carbon::parse($createdAt)->toDateTimeString()
                ]
            ],
        ];
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curl);
    }
}
