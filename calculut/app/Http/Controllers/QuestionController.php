<?php

namespace App\Http\Controllers;

use App\Models\Formulaire;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
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
        $question = new Question($request->all());
        Formulaire::findOrFail($formulaire)->questions()->save($question);
        return $question;
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
    public function update(string $formulaire, string $question, Request $request): void
    {
        $question = Question::findOrFail($question);
        $question->update($request->all());
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
        if($question->type == 'saisie') return;
        $question->donnees()->attach($donnee);
    }

    public function removeDonnee(string $formulaire, string $question, string $donnee): void
    {
        $question = Question::findOrFail($question);
        if($question->type == 'saisie') return;
        $question->donnees()->detach($donnee);
    }
}
