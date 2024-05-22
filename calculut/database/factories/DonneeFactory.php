<?php

namespace Database\Factories;

use App\Models\Donnee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donnee>
 */
class DonneeFactory extends Factory
{
    protected $model = Donnee::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->name(),
            'description' => fake()->sentence(),
            'valeur' => fake()->randomFloat(['min' => 0, 'max' => 100]),
            'unite' => "kgCO2/p",
            'source' => fake()->domainName(),
            'metrique' => 'CO2'
        ];
    }
}
