<?php

namespace App\Actions;

use App\Models\Tag;

class TagAction
{
    /**
     * @param array $tags
     * @return array
     */
    public function firstOrCreateTags(array $tags): array
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
}
