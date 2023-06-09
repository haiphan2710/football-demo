<?php

namespace HaiPG\LaravelCore\Common;

class PassportSupporter
{
    /**
     * Break token from the request (not contain 'Bearer ')
     * The result is id in the oauth_access_tokens table
     *
     * @param $token
     * @return string
     */
    public static function breakToken($token)
    {
        $breaking   = explode('.', $token);
        $jsonHeader = base64_decode($breaking[1]);
        $data       = json_decode($jsonHeader, true);

        return $data['jti'];
    }
}
