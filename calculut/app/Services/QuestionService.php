<?php

namespace App\Services;

use App\Models\Formulaire;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{
    public function createQuestion(string $formulaire, array $validatedData)
    {
        $question = new Question($validatedData);
        Formulaire::findOrFail($formulaire)->questions()->save($question);

        if($question->type == 'unique') {
            foreach($validatedData['donneesIds'] as $donneesId) {
                $question->donnees()->attach($donneesId);
            }
        }

        return $question;
    }

    public function updateQuestion(string $formulaire, string $question, array $validatedData): Question
    {
        $fetchQuestion = Question::findOrFail($question);
        $fetchQuestion->update($validatedData);

        if($fetchQuestion->type == 'unique') {
            $fetchQuestion->donnees()->detach();
            foreach($validatedData['donneesIds'] as $donneesId) {
                $fetchQuestion->donnees()->attach($donneesId);
            }
        }

        // Pour que le updated_at soit mis à jour, comme ça on sait si le formulaire est à jour dans les bilans
        $fetchQuestion->formulaire->save();

        return $fetchQuestion;
    }
}
