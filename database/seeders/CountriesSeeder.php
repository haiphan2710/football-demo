<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Services\Football\CountryService;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = resolve(CountryService::class)->all();

        Country::query()->insert(
            collect($data['response'])
                ->whereNotNull('code')
                ->push([
                    'name' => 'World',
                    'code' => 'World',
                    'flag' => null,
                ])
                ->all()
        );
    }
}
