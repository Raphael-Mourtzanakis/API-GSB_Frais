<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisController;
use App\Http\Controllers\PraticienController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Le middleware sert à vérifier si on est connecté avec un compte de visiteur avec un token pour sécuriser une page
// Le name sert à prendre en compte une valeur si elle n'existe pas je crois

// Ces routes ont tous "/api" avant, dans l'URL (par exemple : "/api/visiteur/initpwd")

//Route::post('/visiteur/initpwd', [VisiteurController::class, 'initPasswordAPI']);
Route::post('/authentifier', [VisiteurController::class, 'authAPI']);
Route::post('/deconnecter', [VisiteurController::class, 'logoutAPI'])->middleware('auth:sanctum');
Route::get('/unauthorized', [VisiteurController::class, 'unauthorizedAPI'])->name('login');

Route::get('/Frais/{id}', [FraisController::class, 'getFraisAPI'])->middleware('auth:sanctum');
Route::post('/Frais/ajouter', [FraisController::class, 'addFraisAPI'])->middleware('auth:sanctum');
Route::post('/Frais/modifier', [FraisController::class, 'updateFraisAPI'])->middleware('auth:sanctum');
Route::delete('/Frais/supprimer', [FraisController::class, 'removeFraisAPI'])->middleware('auth:sanctum');
Route::get('/Frais/lister/{idVisiteur}', [FraisController::class, 'listFraisAPI'])->middleware('auth:sanctum');

Route::get('/Praticien/{id}', [PraticienController::class, 'getPraticienAPI'])->middleware('auth:sanctum');
Route::post('/Praticien/rechercher', [PraticienController::class, 'searchPraticienAPI'])->middleware('auth:sanctum');
Route::get('/Praticien/lister/{id_praticien}/specialites', [PraticienController::class, 'listSpecialitesDunPraticienAPI'])->middleware('auth:sanctum');
Route::get('/Praticien/lister/{id_praticien}/specialites_non_attribuees', [PraticienController::class, 'listSpecialitesNonAttribueesAunPraticienAPI'])->middleware('auth:sanctum');
Route::post('/Praticien/ajouter/specialite', [PraticienController::class, 'addSpecialiteAunPraticienAPI'])->middleware('auth:sanctum');
Route::delete('/Praticien/{id_praticien}/supprimer/specialite/{id_specialite}', [PraticienController::class, 'removeSpecialiteAunPraticienAPI'])->middleware('auth:sanctum');
