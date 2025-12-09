<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route::post('/visiteur/initpwd', [VisiteurController::class, 'initPasswordAPI']);
Route::post('/visiteur/auth', [VisiteurController::class, 'authAPI']);
Route::post('/visiteur/logout', [VisiteurController::class, 'logoutAPI'])->middleware('auth:sanctum');
Route::get('/visiteur/unauthorized', [VisiteurController::class, 'unauthorizedAPI'])->name('login');
