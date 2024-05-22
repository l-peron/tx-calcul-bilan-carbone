<?php

namespace Database\Factories;

use App\Enums\QuestionType;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;
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
            'variable' => fake()->word(),
            'type' => fake()->randomElement(QuestionType::class),
        ];
    }
}
