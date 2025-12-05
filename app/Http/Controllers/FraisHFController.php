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
            $desFraisHF = $service->getListFraisHF($id_frais,$id_visiteur);
            if (isset($id_visiteur)) {
                return view('listFraisHF', compact('desFraisHF'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
    public function addFraisHF() {
        try {
            $unFraisHF = new FraisHF();
            $id_visiteur = session("id_visiteur");
            if (isset($id_visiteur)) {
                return view('formFraisHF', compact('unFraisHF'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function validFraisHF(Request $request) {
        try {
            $id = $request->input('id');
            $service = new FraisHFService();
            if ($id) {
                $unFraisHF = $service->getunFraisHF($id);
                $unFraisHF->date_fraishorsforfait = today(); // Définir la date au moment de la modification
            } else {
                $unFraisHF = new FraisHF();
            }
            $unFraisHF->montant_fraishorsforfait = $request->input("montant");
            $unFraisHF->lib_fraishorsforfait = session("libelle");

            $service->saveunFraisHF($unFraisHF);

            return redirect("/listerFrais");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editFraisHF($id) {
        try {
            $service = new FraisHFService();
            $etats = $service->getListEtat();
            $unFraisHF = $service->getunFraisHF($id);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formFrais', compact('unFraisHF', 'etats', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeFraisHF($id) {
        try {
            $id_visiteur = session("id_visiteur");
            $service = new FraisHFService();
            $service->deleteFraisHF($id,$id_visiteur);

            return redirect("/listerFrais");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
