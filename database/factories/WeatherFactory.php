<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WeatherFactory extends Factory
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
        $locationArray = array(
            'lat' => $this->faker->randomFloat(rand(1, 4), 20, 90),
            'lon' => '-' . $this->faker->randomFloat(rand(1, 4), 20, 90),
            'city' => $randomCity,
            'state' => $randomState,
        );

        //Random temperatures
        $tempArray = [];
        for($i = 0; $i <=24; $i++) {
            $tempArray[] = $this->faker->randomFloat(1, 20, 40);
        };

        return [
            'date' => $this->faker->dateTimeBetween('-2 years', '+2 years', 'GMT'),
            'location' => json_encode($locationArray),
            'temperature' => json_encode($tempArray),
        ];
    }
}
