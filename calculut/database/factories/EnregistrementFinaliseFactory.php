<?php

namespace Database\Factories;

use App\Models\EnregistrementFinalise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EnregistrementFinalise>
 */
class EnregistrementFinaliseFactory extends Factory
{
    protected $model = EnregistrementFinalise::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auteur' => fake()->name(),
            'enregistrement' => json_encode([]),
            'commentaire' => fake()->paragraph()
        ];
    }
}
