<?php

namespace HaiPG\LaravelCore\Common;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class Line
{
    public static function sendMessage($userId, $message)
    {
        $httpClient = new CurlHTTPClient(config('services.line_bot.channel_token'));
        $bot = new LINEBot($httpClient, ['channelSecret' => config('services.line_bot.channel_secret')]);
        return $bot->pushMessage($userId, $message);
    }
}
