<?php

namespace App\Enums;

use HaiPG\LaravelCore\Contracts\EnumContract;

class LeagueType implements EnumContract
{
    const LEAGUE = "league";
    const CUP    = "cup";

    /**
     * Get all constants
     */
    public static function all()
    {
        return [
            //
        ];
    }
}
