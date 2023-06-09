<?php

namespace HaiPG\LaravelCore\Common;

use App\Models\Translate;

class Timezone
{
    const TIMEZONE_DEFAULT = 'UTC';
    const TIMEZONE_TOKYO = 'Asia/Tokyo';
    const TIMEZONE_SHANGHAI = 'Asia/Shanghai';
    const TIME_MIDNIGHT = '23:30:00';

    public static function generateTimezone($lang)
    {
        switch ($lang) {
            case Translate::LANG_EN:
                return self::TIMEZONE_DEFAULT;
                break;
            case Translate::LANG_JA:
                return self::TIMEZONE_TOKYO;
                break;
            case Translate::LANG_ZH:
                return self::TIMEZONE_SHANGHAI;
                break;
            default:
                break;
        }
    }

    /**
     * Common function get current Timezone of Request data Header.
     * @return mixed|string
     */
    public static function currentTz()
    {
        $timezone = strtoupper(app('request')->header('timezone'));

        // case UTC±00:00 is UTC
        $pattern = '/^(UTC)[+-][0-9]{2}:[0-9]{2}$/';

        if (!empty($timezone) && preg_match($pattern, $timezone) == true) {
            return str_replace('UTC', '', $timezone);
        }

        return self::TIMEZONE_DEFAULT;
    }

    public static function currentMilliseconds()
    {
        return round(microtime(true) * 1000);
    }
}
