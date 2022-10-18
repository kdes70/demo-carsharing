<?php

namespace Database\Seeders;

use App\Domains\Car\Car;
use App\Domains\Car\CarModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CarSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        (new Car)->delete();

        CarModel::chunk(500, function (Collection $chunk) {
            $carData = $chunk->map(function (CarModel $carModel) {
                $modelMake = Car::factory([
                    'model_id' => $carModel->id,
                ])->make()->toArray();

                return [
                    ...$modelMake,
                    ...['created_at' => now(), 'updated_at' => now()],
                ];
            });

            Car::insert($carData->all());
        });
    }

}
