<?php

namespace App\Http\Controllers;

use App\Services\Football\OddService;

class OddController extends Controller
{
    public function preMatch()
    {
        dd(resolve(OddService::class)->setParams([
            'fixture' => 1027909,
            'bookmaker' => 1
        ])->preMatch());
    }
}
