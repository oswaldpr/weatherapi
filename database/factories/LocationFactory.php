<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //Random cities
        $cityArray = [
            'Alberta',
            'British Columbia',
            'Manitoba',
            'New Brunswick',
            'Newfoundland',
            'Northwest Territories',
            'Nova Scotia',
            'Nunavut',
            'Ontario',
            'Ontario',
            'Prince Edward Island',
            'Quebec',
            'Yukon Territory',
        ];

        //Random states
        $stateArray = [
            'Nashville',
            'Tennessee',
            'Monroe',
            'Louisiana',
            'Shreveport',
        ];

        // Random location
        $randomCity = $cityArray[array_rand($cityArray)];
        $randomState = $stateArray[array_rand($stateArray)];
        return array(
            'lat' => $this->faker->randomFloat(rand(1, 4), 20, 90),
            'lon' => '-' . $this->faker->randomFloat(rand(1, 4), 20, 90),
            'city' => $randomCity,
            'state' => $randomState,
        );
    }
}
