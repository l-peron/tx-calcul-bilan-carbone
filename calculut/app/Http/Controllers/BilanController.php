<?php

namespace App\Http\Controllers;

use App\Http\Requests\BilanRequest;
use App\Models\Bilan;
use App\Models\Formulaire;
use App\Services\BilanService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BilanController extends Controller
{
    public function __construct(private Bilanservice $bilanService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Collection
    {
        $asso = $request->query('asso');
        if($asso == null) {
            return Bilan::with(['enregistrementFinalises', 'evenement'])->get();
        } else {
            return Bilan::with(['enregistrementFinalises', 'evenement'])->where('asso', $asso)->get();
        }
    }

    public function indexByAsso(string $asso): Collection
    {
        return Bilan::with('evenement')->where('asso', $asso)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BilanRequest $request): ?Bilan
    {
        return $this->bilanService->createBilan($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Builder|array|Collection|Model
    {
        return Bilan::with(['evenement', 'formulaires'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->bilanService->updateBilan($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bilan = Bilan::findOrFail($id);
        $bilan->delete();
    }

    public function duplicate(string $bilan): void
    {
        $this->bilanService->duplicateBilan($bilan);
    }
}
