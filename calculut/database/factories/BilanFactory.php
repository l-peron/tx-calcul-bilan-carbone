<?php

namespace Database\Factories;

use App\Enums\FormulaireSecteur;
use App\Models\Bilan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bilan>
 */
class BilanFactory extends Factory
{
    protected $model = Bilan::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->sentence(),
            'type' => 'event',
            'auteur' => fake()->name(),
            'asso' => fake()->name(),
            'pole_asso' => fake()->name(),
            'enregistrement' => json_encode([]),
        ];
    }
}
