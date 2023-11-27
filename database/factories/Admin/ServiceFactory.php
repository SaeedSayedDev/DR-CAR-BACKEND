<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'price' => fake()->randomFloat(2, 50, 200),
            'discount_price' => fake()->randomFloat(2, 40, 150),
            'price_unit' => fake()->boolean,
            'quantity_unit' => fake()->numberBetween(1, 5),
            'duration' => fake()->time('H:i:s', '02:00:00'),
            'featured' => fake()->boolean,
            'enable_booking' => fake()->boolean,
            'rating' => fake()->numberBetween(1, 5),
        ];
    }
}
