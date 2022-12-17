<?php

namespace App\Actions;

use App\Models\Community;
use App\Models\Link;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LinkAction
{
    public function rules(): array
    {
        return [
            'url' => 'required|url',
            'note' => 'nullable',
            'tags' => 'array',
            'tags.*' => 'string|max:255|alpha_dash'
        ];
    }

    /**
     * @param array $request
     * @param Community|Model $community
     * @param User|Model|null $user
     * @return Link
     * @throws ValidationException
     */
    public function create(array $request, Community|Model $community, User|Model $user = null): Link
    {
        $data = Validator::make($request, $this->rules())->validate();

        if ($user == null && auth()->check()) {
            $user = auth()->user();
        }

        $link = new Link();
        $link->url = $data['url'];
        $link->note = $data['note'];
        $link->created_by = $user->id;
        $link->updated_by = $user->id;
        $link->community_id = $community->id;
        $link->save();

        $link->tags()->sync((new TagAction())->firstOrCreateTags($data['tags']));

        $community->load("webhooks");

        (new WebhookAction())->sendCommunityWebhooks($link, $user);

        return $link;
    }
}
