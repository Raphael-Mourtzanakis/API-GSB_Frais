<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisController;
use App\Http\Controllers\FraisFController;
use App\Http\Controllers\FraisHFController;
use App\Http\Controllers\PraticienController;
use App\Http\Controllers\SpecialiteController;
use App\Http\Controllers\PrescrireController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Le middleware sert à vérifier si on est connecté avec un compte de visiteur avec un token pour sécuriser une page
// Le name sert à prendre en compte une valeur si elle n'existe pas je crois

// Ces routes ont tous "/api" avant, dans l'URL (par exemple : "/api/Visiteur/initpwd")

//Route::post('/Visiteur/initpwd', [VisiteurController::class, 'initPasswordAPI']);
Route::post('/Visiteur/authentifier', [VisiteurController::class, 'authAPI']);
Route::post('/Visiteur/deconnecter', [VisiteurController::class, 'logoutAPI'])->middleware('auth:sanctum');
Route::get('/Visiteur/unauthorized', [VisiteurController::class, 'unauthorizedAPI'])->name('login');

Route::get('/Frais/obtenir/{id}', [FraisController::class, 'getFraisAPI'])->middleware('auth:sanctum');
Route::get('/Frais/lister/{idVisiteur}', [FraisController::class, 'listFraisAPI'])->middleware('auth:sanctum');
Route::post('/Frais/ajouter', [FraisController::class, 'addFraisAPI'])->middleware('auth:sanctum');
Route::post('/Frais/modifier', [FraisController::class, 'updateFraisAPI'])->middleware('auth:sanctum');
Route::delete('/Frais/supprimer', [FraisController::class, 'removeFraisAPI'])->middleware('auth:sanctum');
Route::get('/Frais/{id_frais}/montant-saisi/obtenir', [FraisController::class, 'getMontantSaisiAPI'])->middleware('auth:sanctum');

Route::get('/Etat/lister', [FraisController::class, 'listEtatAPI'])->middleware('auth:sanctum');



// En cours ...
Route::get('/Frais/{id_frais}/hors-forfait/obtenir/{id_fraisHF}', [FraisHFController::class, 'getFraisHF_API'])->middleware('auth:sanctum');
Route::get('/Frais/{id_frais}/hors-forfait/lister/{idVisiteur}', [FraisHFController::class, 'listFraisHF_API'])->middleware('auth:sanctum');
Route::post('/Frais/hors-forfait/ajouter', [FraisHFController::class, 'addFraisHF_API'])->middleware('auth:sanctum');
Route::post('/Frais/hors-forfait/modifier', [FraisHFController::class, 'updateFraisHF_API'])->middleware('auth:sanctum');
Route::delete('/Frais/hors-forfait/supprimer', [FraisHFController::class, 'removeFraisHF_API'])->middleware('auth:sanctum');

Route::get('/Frais/{id_frais}/forfait/obtenir/{id_fraisF}', [FraisController::class, 'getFraisF_API'])->middleware('auth:sanctum');
Route::get('/Frais/{id_frais}/forfait/lister/{idVisiteur}', [FraisController::class, 'listFraisF_API'])->middleware('auth:sanctum');
Route::get('/Frais/{id_frais}/forfaits_non_attribues/lister', [FraisController::class, 'listFraisF_API'])->middleware('auth:sanctum');
Route::post('/Frais/forfait/ajouter', [FraisController::class, 'addFraisF_API'])->middleware('auth:sanctum');
Route::post('/Frais/forfait/modifier', [FraisController::class, 'updateFraisF_API'])->middleware('auth:sanctum');
Route::delete('/Frais/forfait/supprimer', [FraisController::class, 'removeFraisF_API'])->middleware('auth:sanctum');




Route::get('/Frais_forfait/obtenir/{id}', [FraisFController::class, 'getFraisF_API'])->middleware('auth:sanctum');
Route::get('/Frais_forfait/lister', [FraisFController::class, 'listFraisF_API'])->middleware('auth:sanctum');
Route::post('/Frais_forfait/ajouter', [FraisFController::class, 'addFraisF_API'])->middleware('auth:sanctum');
Route::post('/Frais_forfait/modifier', [FraisFController::class, 'updateFraisF_API'])->middleware('auth:sanctum');
Route::delete('/Frais_forfait/supprimer', [FraisFController::class, 'removeFraisF_API'])->middleware('auth:sanctum');

Route::get('/Praticien/obtenir/{id}', [PraticienController::class, 'getPraticienAPI'])->middleware('auth:sanctum');
Route::get('/Praticien/lister', [PraticienController::class, 'listPraticienAPI'])->middleware('auth:sanctum');

Route::get('/Praticien/{id_praticien}/specialites/lister', [PraticienController::class, 'listSpecialitesDunPraticienAPI'])->middleware('auth:sanctum');
Route::get('/Praticien/{id_praticien}/specialites_non_attribuees/lister', [PraticienController::class, 'listSpecialitesNonAttribueesAunPraticienAPI'])->middleware('auth:sanctum');
Route::post('/Praticien/ajouter/specialite', [PraticienController::class, 'addSpecialiteAunPraticienAPI'])->middleware('auth:sanctum');
Route::delete('/Praticien/{id_praticien}/supprimer/specialite/{id_specialite}', [PraticienController::class, 'removeSpecialiteAunPraticienAPI'])->middleware('auth:sanctum');

Route::get('/Specialite/obtenir/{id}', [SpecialiteController::class, 'getSpecialiteAPI'])->middleware('auth:sanctum');
Route::get('/Specialite/lister', [SpecialiteController::class, 'listSpecialiteAPI'])->middleware('auth:sanctum');
Route::post('/Specialite/ajouter', [SpecialiteController::class, 'addSpecialiteAPI'])->middleware('auth:sanctum');
Route::post('/Specialite/modifier', [SpecialiteController::class, 'updateSpecialiteAPI'])->middleware('auth:sanctum');
Route::delete('/Specialite/supprimer', [SpecialiteController::class, 'removeSpecialiteAPI'])->middleware('auth:sanctum');

Route::get('/Classement/familles_medicaments/lister', [PrescrireController::class, 'listClassementFamilleMedocAPI'])->middleware('auth:sanctum');
Route::post('/Classement/prescription_medicaments/lister', [PrescrireController::class, 'listClassementPrescriptionMedocAPI'])->middleware('auth:sanctum');
