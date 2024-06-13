<?php

namespace App\Http\Controllers;

use App\Models\Bilan;
use App\Models\Formulaire;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FormulaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Collection
    {
        $publie = $request->query('publie');
        if($publie == null) {
            return Formulaire::all();
        } else {
            return Formulaire::where('publie', true)->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Formulaire
    {
        return Formulaire::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Formulaire
    {
        return Formulaire::with('questions')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): void
    {
        $formulaire = Formulaire::find($id);
        $formulaire->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        Formulaire::destroy($id);
    }
}
