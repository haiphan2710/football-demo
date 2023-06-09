<?php

namespace App\Http\Controllers;

use App\Enums\LeagueType;
use App\Services\Football\LeagueService;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function all()
    {
        $data = resolve(LeagueService::class)
            ->setParams([
//                'season'  => 2023,
//                'current' => 'true',
//                'type'    => LeagueType::CUP,
//                'country' => 'World',
                'search'  => 'UEFA'
            ])->all();
        dd(collect($data['response'])->all());
    }
}
