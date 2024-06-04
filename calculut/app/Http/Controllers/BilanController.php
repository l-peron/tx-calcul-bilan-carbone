<?php

namespace App\Http\Controllers;

use App\Models\Bilan;
use App\Models\Formulaire;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BilanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Collection
    {
        $asso = $request->query('asso');
        if($asso == null) return Bilan::with(['enregistrementFinalises', 'evenement'])->get();
        else return Bilan::with(['enregistrementFinalises', 'evenement'])->where('asso', $asso)->get();
    }

    public function indexByAsso(string $asso): Collection
    {
        return Bilan::with('evenement')->where('asso', $asso)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): ?Bilan
    {
        $userFullName = $request->session()->get("fullName");

        $bilan = $request->all();
        $bilan['auteur'] = $userFullName;

        return Bilan::create($bilan);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Bilan
    {
        return Bilan::with('formulaires')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bilan = Bilan::findOrFail($id);
        $bilan->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bilan = Bilan::findOrFail($id);
        $bilan->delete();
    }

    public function addFormulaire(string $bilan, string $formulaire): void
    {
        $bilan = Bilan::findOrFail($bilan);
        $bilan->formulaires()->attach($formulaire);
    }

    public function removeFormulaire(string $bilan, string $formulaire): void
    {
        $bilan = Bilan::findOrFail($bilan);
        $bilan->formulaires()->detach($formulaire);
    }
}
