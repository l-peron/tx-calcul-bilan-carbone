<?php

namespace App\Http\Controllers;

use App\Enums\QuestionType;
use App\Models\Formulaire;
use App\Models\Question;
use App\Services\QuestionService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuestionController extends Controller
{
    public function __construct(private QuestionService $questionService){}

    /**
     * Display a listing of the resource.
     */
    public function index(string $formulaire): Collection
    {
        return Formulaire::findOrFail($formulaire)->questions;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $formulaire, Request $request): Question
    {
        $validatedData = $request->validate([
            'intitule' => 'required|string',
            'description' => 'nullable|string',
            'variable' => 'required|string',
            'type' => [Rule::Enum(QuestionType::class)],
            'donneesIds' => ['nullable', 'array'],
        ]);

        return $this->questionService->createQuestion($formulaire, $validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $formulaire, string $question): Question
    {
        return Question::findOrFail($question);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(string $formulaire, string $question, Request $request): Question
    {
        $validatedData = $request->validate([
            'intitule' => 'required|string',
            'description' => 'nullable|string',
            'variable' => 'required|string',
            'type' => [Rule::Enum(QuestionType::class)],
            'donneesIds' => ['nullable', 'array'],
        ]);

        return $this->questionService->updateQuestion($formulaire, $question, $validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $formulaire, string $question): void
    {
        Question::destroy($question);
    }

    public function addDonnee(string $formulaire, string $question, string $donnee): void
    {
        $question = Question::findOrFail($question);
        if($question->type != 'saisie') {
            $question->donnees()->attach($donnee);
        }
    }

    public function removeDonnee(string $formulaire, string $question, string $donnee): void
    {
        $question = Question::findOrFail($question);
        if($question->type == 'saisie') {
            $question->donnees()->attach($donnee);
        }
        $question->donnees()->detach($donnee);
    }
}
