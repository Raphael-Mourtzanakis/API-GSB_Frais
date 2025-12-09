<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Le middleware sert à vérifier si on est connecté avec un compte de visiteur avec un token pour sécuriser une page
// Le name sert à prendre en compte une valeur si elle n'existe pas je crois

//Route::post('/visiteur/initpwd', [VisiteurController::class, 'initPasswordAPI']);
Route::post('/visiteur/auth', [VisiteurController::class, 'authAPI']);
Route::post('/visiteur/logout', [VisiteurController::class, 'logoutAPI'])->middleware('auth:sanctum');
Route::get('/visiteur/unauthorized', [VisiteurController::class, 'unauthorizedAPI'])->name('login');

Route::get('/frais/{idFrais}', [FraisController::class, 'getFraisAPI'])->middleware('auth:sanctum');
Route::post('/frais/ajout', [FraisController::class, 'addFraisAPI'])->middleware('auth:sanctum');
Route::post('/frais/modif', [FraisController::class, 'updateFraisAPI'])->middleware('auth:sanctum');
Route::delete('/frais/suppr', [FraisController::class, 'removeFraisAPI'])->middleware('auth:sanctum');
Route::get('/frais/liste/{idVisiteur}', [FraisController::class, 'listFraisAPI'])->middleware('auth:sanctum');
