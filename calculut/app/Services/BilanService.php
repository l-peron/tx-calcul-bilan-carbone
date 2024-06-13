<?php

namespace App\Services;

use App\Http\Requests\BilanRequest;
use App\Models\Bilan;
use DateTime;
use Illuminate\Http\Request;

class BilanService
{
    public function createBilan(BilanRequest $request): Bilan
    {
        $userFullName = $request->session()->get("fullName");

        $bilanReq = $request->all();
        $bilanReq['auteur'] = $userFullName;

        $bilan = Bilan::create($bilanReq);
        $bilan->evenement()->create($request->all());

        return $bilan;
    }

    public function updateBilan(Request $request, string $id)
    {
        $bilan = Bilan::findOrFail($id);
        $bilan->update($request->all());

        $bilan->formulaires()->detach();
        foreach($bilan->enregistrement->getFormulaires() as $formulaire) {
            $bilan->formulaires()->attach($formulaire->getId());
        }

        $bilan->evenement->update($request->all());
    }

    public function duplicateBilan(string $bilan)
    {
        $bilan = Bilan::findOrFail($bilan);
        $new_bilan = $bilan->replicate();

        $new_bilan->intitule = $bilan->intitule . " Copie";

        $new_bilan->save();

        $new_bilan->evenement()->create([
            "debut" => new DateTime(),
            "fin" => new DateTime(),
        ]);
    }

    public function deleteBilan(string $bilan)
    {
        $bilan = Bilan::findOrFail($bilan);
        $bilan->formulaires()->detach();
        $bilan->evenement()->delete();
        $bilan->delete();
    }
}
