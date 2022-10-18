<?php

namespace Database\Factories\Domains\Car;

use App\Domains\Car\Car;
use App\Domains\Car\Enums\CarStatusEnum;
use App\Domains\Car\Enums\CatTypeEnum;
use App\Domains\Car\Enums\TransmissionEnum;
use App\Domains\Car\CarModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Car\Car>
 */
class CarFactory extends Factory
{

    protected $model = Car::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_id' => CarModel::factory(),
            'year' => $this->faker->year,
            'type' => $this->faker->randomElement(CatTypeEnum::getCatTypes()),
            'transmission' => $this->faker->randomElement(
                TransmissionEnum::getTransmissions()
            ),
            'status' => $this->faker->randomElement(CarStatusEnum::getStates()),
            'description' => $this->faker->sentence,
        ];
    }

}
