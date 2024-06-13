<?php

namespace App\Services;

use App\Models\Formulaire;

class FormulaireService
{
    public function deleteFormulaire(string $id)
    {
        $formulaire = Formulaire::findOrFail($id);
        $formulaire->questions()->delete();
        $formulaire->delete();
    }
}
