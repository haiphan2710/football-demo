<?php

namespace HaiPG\LaravelCore\Common;

class VerifyCode
{
    public static function generate()
    {
        do {
            $random = (string) rand(1000, 9999);
        } while ((strpos($random, '0') !== false) || (strpos($random, '7') !== false));

        return $random;
    }
}
