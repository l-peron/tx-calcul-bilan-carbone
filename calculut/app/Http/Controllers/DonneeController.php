<?php

namespace App\Http\Controllers;

use App\Models\Donnee;
use App\Services\DonneeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DonneeController extends Controller
{
    public function __construct(private DonneeService $donneeService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Donnee::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Donnee
    {
        return Donnee::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Donnee|array
    {
        return Donnee::with('questions')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): bool
    {
        $donnee = Donnee::findOrFail($id);
        return $donnee->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): void
    {
        Donnee::find($id)->delete();
    }

    public function duplicate(string $donnee): void
    {
        $this->donneeService->duplicateDonnee($donnee);
    }
}
