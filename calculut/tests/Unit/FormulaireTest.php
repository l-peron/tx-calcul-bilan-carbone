<?php

namespace Tests\Unit;

use App\Models\Donnee;
use App\Models\Formulaire;
use App\Models\Question;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormulaireTest extends TestCase
{
    use RefreshDatabase, InteractsWithDatabase;

    public function test_creer_un_formulaire(): void
    {
        $formulaire = Formulaire::factory()->has(Question::factory()->count(5))->create();
        $this->assertModelExists($formulaire);
    }

    public function test_question_du_formulaire_sauvegardees(): void
    {
        $formulaire = Formulaire::factory()->has(Question::factory()->count(5))->create();
        $this->assertDatabaseCount('questions', 5);
    }

    public function test_supprimer_un_formulaire(): void
    {
        $formulaire = Formulaire::factory()->create();
        $formulaire->delete();
        $this->assertSoftDeleted($formulaire);
    }
}
