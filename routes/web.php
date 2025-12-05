<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisController;
use App\Http\Controllers\FraisHFController;

Route::get('/', function () {
    return view('home');
});

Route::get('/connecter', [VisiteurController::class, 'login']);
Route::post('/authentifier', [VisiteurController::class, 'auth']);
Route::get('/deconnecter', [VisiteurController::class, 'logout']);

Route::get('/listerFrais', [FraisController::class, 'listFrais']);
Route::get('/ajouterFrais', [FraisController::class, 'addFrais']);
Route::get('/editerFrais/{id}', [FraisController::class, 'editFrais']);
Route::post('/validerFrais', [FraisController::class, 'validFrais']);
Route::get('/supprimerFrais/{id}', [FraisController::class, 'removeFrais']);

Route::get('/listerFraisHF/{id_frais}', [FraisHFController::class, 'listFraisHF']);
