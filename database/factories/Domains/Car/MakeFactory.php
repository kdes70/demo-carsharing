<?php

namespace Database\Factories\Domains\Car;

use App\Domains\Car\Make;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domains\Car\Make>
 */
class MakeFactory extends Factory
{

    protected $model = Make::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'code' => strtoupper($this->faker->bothify('???-###')),
            'logo' => $this->faker->image,
        ];
    }

}
