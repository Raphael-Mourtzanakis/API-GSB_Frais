<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisController;
use App\Http\Controllers\FraisHFController;
use App\Http\Controllers\FraisFController;
use App\Http\Controllers\PraticienController;
use App\Http\Controllers\SpecialiteController;

Route::get('/', function () {
    return view('home');
});

Route::get('/connecter', [VisiteurController::class, 'login']);
Route::post('/authentifier', [VisiteurController::class, 'auth']);
Route::get('/deconnecter', [VisiteurController::class, 'logout']);

Route::get('/Frais/lister', [FraisController::class, 'listFrais']);
Route::get('/Frais/ajouter', [FraisController::class, 'addFrais']);
Route::get('/Frais/modifier/{id}', [FraisController::class, 'editFrais']);
Route::post('/Frais/valider', [FraisController::class, 'validFrais']);
Route::get('/Frais/supprimer/{id}', [FraisController::class, 'removeFrais']);

Route::get('/Frais/modifier/{id_frais}/hors-forfait/lister', [FraisHFController::class, 'listFraisHF']);
Route::get('/Frais/modifier/{id_frais}/hors-forfait/ajouter', [FraisHFController::class, 'addFraisHF']);
Route::get('/Frais/modifier/{id_frais}/hors-forfait/modifier/{id_fraisHF}', [FraisHFController::class, 'editFraisHF']);
Route::post('/Frais/modifier/hors-forfait/valider', [FraisHFController::class, 'validFraisHF']);
Route::get('/Frais/modifier/{id_frais}/hors-forfait/supprimer/{id_fraisHF}', [FraisHFController::class, 'removeFraisHF']);

Route::get('/Frais/modifier/{id_frais}/forfait/lister', [FraisFController::class, 'listFraisF']);
Route::post('/Frais/modifier/forfait/ajouter', [FraisFController::class, 'addFraisF']);
Route::get('/Frais/modifier/{id_frais}/forfait/modifier/{id_fraisF}', [FraisFController::class, 'editFraisF']);
Route::post('/Frais/modifier/forfait/valider', [FraisFController::class, 'validFraisF']);
Route::get('/Frais/modifier/{id_frais}/forfait/supprimer/{id_fraisF}', [FraisFController::class, 'removeFraisF']);

Route::get('/Praticien/rechercher', [PraticienController::class, 'searchPraticien']);
Route::post('/Praticien/lister', [PraticienController::class, 'listPraticien']);

Route::get('/Praticien/specialites/{id_praticien}/lister', [PraticienController::class, 'listSpecialites']);
Route::post('/Praticien/specialites/ajouter', [PraticienController::class, 'addSpecialite']);
Route::get('/Praticien/specialites/{id_praticien}/supprimer/{id_specialite}', [PraticienController::class, 'removeSpecialite']);

Route::get('/Specialite/lister', [SpecialiteController::class, 'listSpecialite']);
Route::get('/Specialite/ajouter', [SpecialiteController::class, 'addSpecialite']);
Route::get('/Specialite/modifier/{id}', [SpecialiteController::class, 'editSpecialite']);
Route::post('/Specialite/valider', [SpecialiteController::class, 'validSpecialite']);
Route::get('/Specialite/supprimer/{id}', [SpecialiteController::class, 'removeSpecialite']);
