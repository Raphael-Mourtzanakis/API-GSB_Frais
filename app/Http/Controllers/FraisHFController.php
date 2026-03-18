<?php

namespace App\Http\Controllers;

use App\Models\FraisHF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\FraisHFService;

class FraisHFController extends Controller {
    public function listFraisHF($id_frais) {
        try {
            $service = new FraisHFService();
            $id_visiteur = session("id_visiteur");
            $desFraisHF = $service->getListFraisHF($id_frais, $id_visiteur);
            if (isset($id_visiteur)) {
                return view('listFraisHF', compact('desFraisHF', 'id_frais'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function addFraisHF($id_frais) {
        try {
            $unFraisHF = new FraisHF();
            $id_visiteur = session("id_visiteur");
            if (isset($id_visiteur)) {
                return view('formFraisHF', compact('unFraisHF', 'id_frais'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function validFraisHF(Request $request) {
        try {
            $id_fraisHF = $request->input('id-fraisHF');
			$id_frais = $request->input('id-frais');
            $service = new FraisHFService();
            if ($id_fraisHF) {
                $unFraisHF = $service->getunFraisHF($id_fraisHF);
                $unFraisHF->date_fraishorsforfait = today(); // Définir la date au moment de la modification
            } else {
                $unFraisHF = new FraisHF();
            }
            $unFraisHF->montant_fraishorsforfait = $request->input("montant");
            $unFraisHF->lib_fraishorsforfait = $request->input("libelle");
			$unFraisHF->id_frais = $id_frais;

            $service->saveUnFraisHF($unFraisHF);

            return redirect("/Frais/modifier/".$id_frais."/hors-forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editFraisHF($id_frais, $id_fraisHF) {
        try {
            $service = new FraisHFService();
            $unFraisHF = $service->getunFraisHF($id_fraisHF);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formFraisHF', compact('unFraisHF', 'id_frais', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeFraisHF($id_frais, $id_fraisHF) {
        try {
            $id_visiteur = session("id_visiteur");
            $service = new FraisHFService();
            $service->deleteFraisHF($id_fraisHF, $id_visiteur);

            return redirect("/Frais/modifier/".$id_frais."/hors-forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
