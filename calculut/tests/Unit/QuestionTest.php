<?php

namespace Tests\Unit;

use App\Models\Donnee;
use App\Models\Formulaire;
use App\Models\Question;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase, InteractsWithDatabase;

    public function test_creer_une_question(): void
    {
        $question = Question::factory()->has(Donnee::factory()->count(3))->for(Formulaire::factory())->create();
        $this->assertModelExists($question);
    }

    public function test_donnees_de_question_sauvegardees(): void
    {
        $question = Question::factory()->has(Donnee::factory()->count(3))->for(Formulaire::factory())->create();
        $this->assertDatabaseCount('donnees', 3);
    }
}
