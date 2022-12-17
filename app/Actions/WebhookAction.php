<?php

namespace App\Actions;

use App\Models\Community;
use App\Models\Link;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use JetBrains\PhpStorm\NoReturn;

class WebhookAction
{
    /**
     * @param Link $link
     * @param User $user
     * @return void
     */
    public function sendCommunityWebhooks(Link $link, User $user): void
    {
        $link->load('community', 'community.webhooks', 'tags');
        foreach ($link->community->webhooks as $webhook) {
            $this->sendDiscordWebhook(
                $webhook->url,
                $user->name . " added new link!",
                $link,
                $user,
            );
        }
    }

    /**
     * @param $webhookUrl
     * @param $content
     * @param Link $link
     * @param User $user
     * @return bool|string
     */
    #[NoReturn] public function sendDiscordWebhook($webhookUrl, $content, Link $link, User $user): bool|string
    {
        $data = [
            "content" => $content,
            "embeds" => [
                [
                    "title" => $link->url,
                    "description" => $link->note,
                    "color" => 5261029,
                    "fields" => [
                        [
                            "name" => "Tags",
                            "value" => count($link->tags->pluck('name')->toArray()) >= 1 ? implode(", ", $link->tags->pluck('name')->toArray()) : "`no tags.`",
                        ],
                    ],
                    "author" => [
                        "name" => $link->community->name,
                        "url" => URL::to('/@' . $link->community->prefix),
                        "icon_url" => "https://ui-avatars.com/api/?name=" . urlencode($link->community->name) . "&background=5046e5&color=fff",
                    ],
                    "footer" => [
                        "text" => $user->name,
                        "icon_url" => "https://ui-avatars.com/api/?name=" . urlencode($user->name) . "&background=5046e5&color=fff",
                    ],
                    "timestamp" => Carbon::parse($link->created_at)->toDateTimeString()
                ]
            ],
        ];

        $curl = curl_init($webhookUrl);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($curl);
    }
}
