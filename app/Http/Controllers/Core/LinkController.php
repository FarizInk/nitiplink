<?php

namespace App\Http\Controllers\Core;

use App\Actions\LinkAction;
use App\Actions\TagAction;
use App\Helpers\CommunityHelper;
use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\Link;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Laravel\Octane\Exceptions\DdException;

class LinkController extends Controller
{
    /**
     * @param $prefix
     * @param $link_hash
     * @return Response
     */
    public function detailPage($prefix, $link_hash): Response
    {
        return Inertia::render('Community/DetailLink', [
            'link' => Link::byHash($link_hash)?->load(['creator', 'tags']),
        ]);
    }

    /**
     * @return string[]
     */
    private function validation(): array
    {
        return [
            'url' => 'required|url',
            'note' => 'nullable',
            'tags' => 'array',
            'tags.*' => 'string|max:255|alpha_dash'
        ];
    }

    /**
     * @param Request $request
     * @param Community $community
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function create(Request $request, Community $community): \Illuminate\Http\RedirectResponse
    {
        (new LinkAction())->create($request->all(), $community);

        return redirect()->back();
    }

    public function update(Request $request, Community $community, Link $link): \Illuminate\Http\RedirectResponse
    {
        $request->validate($this->validation());
        $link->url = $request->url;
        $link->note = $request->note;
        $link->updated_by = auth()->user()->id;
        $link->save();

        $link->tags()->sync((new TagAction())->firstOrCreateTags($request->tags));

        return redirect()->back();
    }

    public function delete(Community $community, Link $link): \Illuminate\Http\RedirectResponse
    {
        if ($community->id === $link->community_id) {
            $link->delete();
        }

        return redirect()->route('app.community.index', '@' . $community->prefix);
    }
}
