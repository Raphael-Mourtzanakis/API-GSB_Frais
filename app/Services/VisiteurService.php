<?php

namespace App\Services;

use App\Models\Visiteur;
use Illuminate\Support\Facades\Session;

class VisiteurService
{
    public function signIn($login, $password) {
        $visiteur = Visiteur::query()
            ->where("login_visiteur", "=", $login)->first();

        if ($visiteur && $visiteur->pwd_visiteur == $password) {
            Session::put("id_visiteur", $visiteur->id_visiteur);
            Session::put("visiteur", "$visiteur->prenom_visiteur $visiteur->nom_visiteur");
            return true;
        }
        return false;
    }

    public function signOut() {
        if (session("id_visiteur")) {
            Session::remove("id_visiteur");
            return true;
        }
        return false;
    }

    public function getVisiteur($id_visiteur) {
        $visiteur = Visiteur::query()
            ->select("nom_visiteur","prenom_visiteur")
            ->where("id_visiteur", "=", $id_visiteur)->first();
        return $visiteur;
    }
}
