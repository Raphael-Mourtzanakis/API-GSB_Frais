<?php

namespace App\Http\Controllers;

use App\Models\FraisF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\FraisFService;

class FraisFController extends Controller {
    public function listFraisF($id_frais) {
        try {
            $service = new FraisFService();
            $id_visiteur = session("id_visiteur");
            $desFraisF = $service->getListFraisF($id_frais, $id_visiteur);
            if (isset($id_visiteur)) {
                return view('listFraisF', compact('desFraisF', 'id_frais'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function addFraisF($id_frais) {
        try {
            $unFraisF = new FraisF();
            $id_visiteur = session("id_visiteur");
            if (isset($id_visiteur)) {
                return view('formFraisF', compact('unFraisF', 'id_frais'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function validFraisF(Request $request) {
        try {
            $id_fraisF = $request->input('id-fraisF');
			$id_frais = $request->input('id-frais');
            $service = new FraisFService();
            if ($id_fraisF) {
                $unFraisF = $service->getunFraisF($id_fraisF);
                $unFraisF->date_fraishorsforfait = today(); // Définir la date au moment de la modification
            } else {
                $unFraisF = new FraisF();
            }
            $unFraisF->montant_fraishorsforfait = $request->input("montant");
            $unFraisF->lib_fraishorsforfait = $request->input("libelle");
			$unFraisF->id_frais = $id_frais;

            $service->saveUnFraisF($unFraisF);

            return redirect("/Frais/modifier/".$id_frais."/hors-forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editFraisF($id_frais, $id_fraisF) {
        try {
            $service = new FraisFService();
            $unFraisF = $service->getunFraisF($id_fraisF);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formFraisF', compact('unFraisF', 'id_frais', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeFraisF($id_frais, $id_fraisF) {
        try {
            $id_visiteur = session("id_visiteur");
            $service = new FraisFService();
            $service->deleteFraisF($id_fraisF, $id_visiteur);

            return redirect("/Frais/modifier/".$id_frais."/hors-forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
