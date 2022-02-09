<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Weather2Factory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //Random temperatures
        $tempArray = [];
        for($i = 0; $i <=24; $i++) {
            $tempArray[] = $this->faker->randomFloat(1, 20, 40);
        };

        return [
            'date' => $this->faker->dateTimeBetween('-1 years', '+1 years', 'GMT'),
            'location' => $this->faker->numberBetween(1, 5), //Considering we will have it least 5 entries in locationDB
            'temperature' => json_encode($tempArray),
        ];
    }
}
