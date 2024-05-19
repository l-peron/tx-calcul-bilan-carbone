<?php

namespace Database\Factories;

use App\Enums\FormulaireSecteur;
use App\Models\Formulaire;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formulaire>
 */
class FormulaireFactory extends Factory
{
    protected $model = Formulaire::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'intitule' => fake()->sentence(),
            'description' => fake()->sentence(),
            'secteur' => fake()->randomElement(FormulaireSecteur::class),
            'formule' => json_encode([]),
            'publie' => fake()->boolean()
        ];
    }
}
