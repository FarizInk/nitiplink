<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Link;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LinkController extends Controller
{
    public function create(Request $request, $community_hash): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'url' => 'required|url',
            'note' => 'nullable',
            'tags' => 'array',
        ]);

        $community = Community::byHash($community_hash);

        $link = new Link();
        $link->url = $request->url;
        $link->note = $request->note;
        $link->created_by = auth()->user()->id;
        $link->updated_by = auth()->user()->id;
        $link->community_id = $community->id;
        $link->save();

        $tagsId = [];
        foreach ($request->tags as $tag) {
            $tag = Tag::query()->firstOrCreate([
                'name' => strtolower($tag),
            ]);
            $tagsId[] = $tag->id;
        }
        $link->tags()->sync($tagsId);

        $data = [
            "content" => auth()->user()->name . " added new link!",
            "embeds" => [
                [
                    "title" => $request->url,
                    "description" => $request->note,
                    "color" => 5261029,
                    "fields" => [
                        [
                            "name" => "Tags",
                            "value" => count($request->tags) >= 1 ? implode(", ", $request->tags) : "`no tags.`",
                        ],
                    ],
                    "author" => [
                        "name" => $community->name,
                        "url" => URL::to('/@' . $community->prefix),
                        "icon_url" => "https://ui-avatars.com/api/?name=" . urlencode($community->name) . "&background=5046e5&color=fff",
                    ],
                    "footer" => [
                        "text" => auth()->user()->name,
                        "icon_url" => "https://ui-avatars.com/api/?name=" . urlencode(auth()->user()->name) . "&background=5046e5&color=fff",
                    ],
                    "timestamp" => Carbon::parse($link->created_at)->toDateTimeString()
                ]
            ],
        ];
        $curl = curl_init("https://discord.com/api/webhooks/1043885952780730418/oHJSSubH8ifFzRCgvmalt4SDwRe0bp8ZMZGEYyIJhr7FKier1BtI5x_s3sJgNJtQke2g");
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($curl);

        return redirect()->back();
    }
}
