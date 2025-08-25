<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->country(),
            'code' => fake()->unique()->countryCode(),
            'phone_code' => fake()->numberBetween(1, 999),
            'currency' => fake()->currencyCode(),
            'currency_symbol' => fake()->randomElement(['$', '€', '£', '¥', '₹']),
        ];
    }
}
