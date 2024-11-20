<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ucenik>
 */
class UcenikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->create(['tip_korisnika' => 'ucenik'])->id,
            'ime' => $this->faker->firstName(),
            'razred' => $this->faker->numberBetween(1, 8), // osnovna škola, ili 1-4 za srednju
            'odeljenje' => $this->faker->numberBetween(1, 5) ,
            'roditelj_id' => \App\Models\Roditelj::factory(),
        ];
    }
}
