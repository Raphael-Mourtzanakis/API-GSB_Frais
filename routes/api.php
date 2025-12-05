<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/visiteur/initpwd', [VisiteurController::class, 'initPasswordAPI']);
Route::post('/visiteur/auth', [VisiteurController::class, 'auth']);
Route::post('/visiteur/logout', [VisiteurController::class, 'logout']);
Route::post('/visiteur/unauthorized', [VisiteurController::class, 'unauthorized']);
