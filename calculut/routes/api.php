<?php

use App\Http\Controllers\EnregistrementFinaliseController;
use App\Http\Controllers\IdentityController;
use App\Http\Controllers\BilanController;
use App\Http\Controllers\DonneeController;
use App\Http\Controllers\FormulaireController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

// Pour avoir accès à la session
Route::group(['middleware' => ['web']], function () {
    Route::get('assos', [IdentityController::class, 'getMe']);

    // Données
    Route::apiResource('donnees', DonneeController::class);

    // Formulaires
    Route::apiResource('formulaires', FormulaireController::class);

    // Questions
    Route::post('formulaires/{formulaire}/questions/{question}/donnees/{donnee}', [QuestionController::class, 'addDonnee']);
    Route::delete('formulaires/{formulaire}/questions/{question}/donnees/{donnee}', [QuestionController::class, 'removeDonnee']);
    Route::apiResource('formulaires.questions', QuestionController::class);

    // Bilans
    Route::post('bilans/{bilan}/duplicate', [BilanController::class, 'duplicate']);
    Route::apiResource('bilans', BilanController::class);

    // Enregistrement finalisés
    Route::apiResource('bilans.enregistrements',EnregistrementFinaliseController::class);
});


