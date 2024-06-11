<?php

namespace App\Http\Controllers;

use App\Models\Bilan;
use App\Models\EnregistrementFinalise;
use App\Models\Question;
use App\Services\EnregistrementFinaliseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class EnregistrementFinaliseController extends Controller
{
    public function __construct(private EnregistrementFinaliseService $enregistrementFinaliseService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(string $bilan): Collection
    {
        return Bilan::find($bilan)->enregistrementFinalises()->with('bilan')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $bilan, Request $request): EnregistrementFinalise
    {
        $userFullName = $request->session()->get("fullName");

        $enregistrementReq = $request->all();
        $enregistrementReq['auteur'] = $userFullName;

        return $this->enregistrementFinaliseService->saveEnregistrementFinalise($bilan, new EnregistrementFinalise($enregistrementReq));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $bilan, string $enregistrementFinalise)
    {
        return EnregistrementFinalise::with('bilan')->findOrFail($enregistrementFinalise);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $bilan, string $enregistrementFinalise, Request $request): void
    {
        $enregistrementFinalise = Question::findOrFail($enregistrementFinalise);
        $enregistrementFinalise->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $bilan, string $enregistrementFinalise): void
    {
        EnregistrementFinalise::destroy($enregistrementFinalise);
    }
}
