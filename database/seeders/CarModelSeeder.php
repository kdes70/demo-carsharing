<?php

namespace Database\Seeders;

use App\Domains\Car\CarModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new CarModel)->delete();

        $models = collect(config('imports.models'));

        $models->chunk(500)->each(function (Collection $data) {
            CarModel::insert($data->all());
        });
    }
}
