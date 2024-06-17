<?php

namespace App\Services;

use App\Models\Donnee;

class DonneeService
{
    public function duplicateDonnee(string $donnee)
    {
        $donnee = Donnee::findOrFail($donnee);
        $new_donnee = $donnee->replicate();

        $new_donnee->intitule = $donnee->intitule . " Copie";

        $new_donnee->save();
    }
}
