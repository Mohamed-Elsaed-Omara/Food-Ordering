<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 10),
            'min_purchase_amount' => 50,
            'discount' => '10',
            'discount_type' => fake()->randomElement(['fixed', 'percent']),
            'expiry_date' => now()->addDays(30),
            'status' => fake()->boolean(),

        ];
    }
}
