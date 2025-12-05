<?php

namespace App\Http\Controllers;

use App\Models\Frais;
use App\Models\Etat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\FraisService;

class FraisController extends Controller {
    public function listFrais() {
        try {
            $service = new FraisService();
            $id_visiteur = session("id_visiteur");
            $desFrais = $service->getListFrais($id_visiteur);
            if (isset($id_visiteur)) {
                return view('listFrais', compact('desFrais'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function addFrais() {
        try {
            $unFrais = new Frais();
            $etats = [new Etat()];
            $etats[0]->lib_etat = "Fiche créée, saisie en cours";
            $id_visiteur = session("id_visiteur");
            if (isset($id_visiteur)) {
                return view('formFrais', compact('unFrais', 'etats'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function validFrais(Request $request) {
        try {
            $id = $request->input('id');
            $service = new FraisService();
            if ($id) {
                $unFrais = $service->getUnFrais($id);
                $unFrais->datemodification = today(); // Définir la date au moment de la modification
            } else {
                $unFrais = new Frais();
            }
            $unFrais->titre = $request->input("titre");
            $unFrais->id_etat = 2;
            $unFrais->anneemois = $request->input("annee-mois");
            $unFrais->id_visiteur = session("id_visiteur");
            $unFrais->nbjustificatifs = $request->input("nb-justificatifs");
            $unFrais->montantvalide = $request->input("montant-validé");

            $service->saveUnFrais($unFrais);

            return redirect("/listerFrais");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editFrais($id) {
        try {
            $service = new FraisService();
            $etats = $service->getListEtat();
            $unFrais = $service->getUnFrais($id);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formFrais', compact('unFrais', 'etats', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeFrais($id) {
        try {
            $id_visiteur = session("id_visiteur");
            $service = new FraisService();
            $service->deleteFrais($id,$id_visiteur);

            return redirect("/listerFrais");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
