<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Visiteur;
use App\Services\VisiteurService;

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

    public function initPasswordAPI(Request $request) {
        try {
            $request->validate(['pwd_visiteur' => 'required|min:3']);
            $hash = bcrypt($request->json("pwd_visiteur"));
            Visiteur::query()->update(['pwd_visiteur' => $hash]);
            return response()->json(['status' => "Mots de passe réinitialisés"]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function authAPI(Request $request)
    {
        try {
            $request->validate([
                'login'    => 'required',
                'password' => 'required'
            ]);

            $login    = $request->json('login');
            $password = $request->json('password');

            $identifiants = [
                'login_visiteur' => $login,
                'password'       => $password
            ];

            if (!Auth::attempt($identifiants)) {
                return response()->json(['error' => 'Identifiant ou mot de passe incorrect'], 401);
            }

            // création token et retour informations
            $visiteur = $request->user();
            $token = $visiteur->createToken('authToken')->plainTextToken;

            return response()->json([
                'token'      => $token,
                'token_type' => 'Bearer',
                'visiteur'   => [
                    'id_visiteur'    => $visiteur->id_visiteur,
                    'nom_visiteur'   => $visiteur->nom_visiteur,
                    'prenom_visiteur'=> $visiteur->prenom_visiteur,
                    'type_visiteur'  => $visiteur->type_visiteur,
                ]
            ]);

        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function logoutAPI(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'status' => 'Utilisateur déconnecté'
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    public function unauthorizedAPI()
    {
        return response()->json([
            'error' => 'Accès non autorisé'
        ], 401);
    }
}
