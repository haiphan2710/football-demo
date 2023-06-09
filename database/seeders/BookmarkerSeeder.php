<?php

namespace Database\Seeders;

use App\Models\Bookmarker;
use App\Services\Football\OddService;
use Illuminate\Database\Seeder;

class BookmarkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = resolve(OddService::class)->bookmakers();

        Bookmarker::query()->insert($data['response']);
    }
}
