<?php

namespace App\Http\Controllers;

use App\Services\VisiteurService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Visiteur;

class VisiteurController extends Controller {
    public function login()
    {
        return view("formLogin");
    }

    public function auth(Request $request)
    {
        $login = $request->input("login");
        $password = $request->input("password");

        $service = new VisiteurService();
        if ($service->signIn($login, $password)) {
            return redirect(url("/"));
        } else {
            $erreur = "Identifiant ou mot de passe incorrect";
            return view("formLogin", compact("erreur"));
        }
    }

    public function logout()
    {
        $service = new VisiteurService();
        if ($service->signOut()) {
            return redirect(url("/"));
        } else {
            $erreur = "Vous n'êtes déjà pas connecté";
            return view("home", compact("erreur"));
        }
    }
}
