<?php

return [
    'base_uri' => env('FOOTBALL_BASE_URI', 'https://v3.football.api-sports.io'),
    'headers'  => [
        'x-rapidapi-host' => env('FOOTBALL_HOST', 'v3.football.api-sports.io'),
        'x-rapidapi-key'  => env('FOOTBALL_API_TOKEN', '1e1e2e563e39d4c0e083dce085b4cab2'),
    ]
];
