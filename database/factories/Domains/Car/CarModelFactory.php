<?php

namespace Database\Factories\Domains\Car;

use App\Domains\Car\CarModel;
use App\Domains\Car\Make;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Car\CarModel>
 */
class CarModelFactory extends Factory
{
    protected $model = CarModel::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'make_id' => Make::factory(),
            'name' => $this->faker->word,
            'code' => strtoupper($this->faker->bothify('???-###')),
        ];
    }

}
