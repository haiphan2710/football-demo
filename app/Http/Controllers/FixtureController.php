<?php

namespace App\Http\Controllers;

use App\Services\Football\FixtureService;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function all()
    {
        $data = collect(resolve(FixtureService::class)->setParams([
            'date'  => '2023-06-10',
            'status' => 'NS',
            'season' => 2022
        ])->all()['response']);

        $data = $data->filter(function ($fixture) {
            if ($fixture['league']['id'] == 2) {
                return $fixture;
            }
        });

        dd($data);
    }
}
