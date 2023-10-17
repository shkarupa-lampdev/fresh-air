<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Station1756>
 */
class EcoCityDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'place_id' => $this->faker->randomNumber(),
            'measurement_sensor' => $this->faker->word,
            'option' => $this->faker->word,
            'measurement_unit' => $this->faker->word,
            'measurement_value' => $this->faker->randomFloat(2, 0, 100),
            'measurement_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
