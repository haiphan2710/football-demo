<?php

namespace HaiPG\LaravelCore\Common;

class Phone
{
    public static function formatBeforeHandle($phone)
    {
        return '+' . $phone;
    }
}
