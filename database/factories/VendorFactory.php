<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->sentence(),
            'logo' => fake()->imageUrl(100, 100, 'business'),
            'website' => fake()->url(),
            'contact_email' => fake()->email(),
            'contact_phone' => fake()->phoneNumber(),
        ];
    }

    /**
     * Indicate that the vendor is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified' => true,
        ]);
    }

    /**
     * Indicate that the vendor is not verified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'verified' => false,
        ]);
    }
}
