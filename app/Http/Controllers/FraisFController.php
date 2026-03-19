<?php

namespace App\Http\Controllers;

use App\Models\FraisF;
use App\Models\LigneFraisF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\FraisFservice;
use App\Services\LigneFraisFservice;

class FraisFController extends Controller {
    public function listFraisF($id_frais) {
        try {
            $service = new FraisFservice();
            $id_visiteur = session("id_visiteur");
            $desFraisF = $service->getListFraisF($id_frais, $id_visiteur);
			$lesFraisFNonAttribues = $service->getListFraisFNonAttribues($id_frais, $id_visiteur);
            if (isset($id_visiteur)) {
                return view('listFraisF', compact('desFraisF', 'id_frais', 'lesFraisFNonAttribues'));
            } else {
                return redirect("/");
            }
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

	public function addFraisF(Request $request) {
        try {
            $service = new LigneFraisFservice();

            $id_frais = $request->input('id_frais');
			$id_fraisF = $request->input('id_fraisF');

			if ( ($request->input("quantite") !== null) && ($request->input("quantite") > 0) ) {
				$quantite = $request->input("quantite");
			} else {
				$quantite = 1;
			}

            $ligne_fraisforfait = new LigneFraisF();
            $ligne_fraisforfait->id_frais = $id_frais;
            $ligne_fraisforfait->id_fraisforfait = $id_fraisF;
			$ligne_fraisforfait->quantite_ligne = $quantite;

            $service->ajouterUnFraisFpourUnFrais($ligne_fraisforfait);

            return redirect("/Frais/modifier/".$id_frais."/forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

	public function validFraisF(Request $request) {
        try {
            $id_fraisF = $request->input('id-fraisF');
			$id_frais = $request->input('id-frais');

            $service = new LigneFraisFservice();
			$id_visiteur = session("id_visiteur");

			if ( ($request->input("quantite") !== null) && ($request->input("quantite") > 0) ) {
				$quantite = $request->input("quantite");
			} else {
				$quantite = 1;
			}

			$ligne_fraisforfait = new LigneFraisF();
            $ligne_fraisforfait->id_frais = $id_frais;
            $ligne_fraisforfait->id_fraisforfait = $id_fraisF;
			$ligne_fraisforfait->quantite_ligne = $quantite;

            $service->modifierUnFraisFpourUnFrais($ligne_fraisforfait);

            return redirect("/Frais/modifier/".$id_frais."/forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editFraisF($id_frais, $id_fraisF) {
        try {
            $service = new FraisFservice();
			$id_visiteur = session("id_visiteur");
            $unFraisF = $service->getUnFraisFdunFrais($id_frais, $id_fraisF, $id_visiteur);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formFraisFdeFrais', compact('unFraisF', 'id_frais', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeFraisF($id_frais, $id_fraisF) {
        try {
            $service = new LigneFraisFservice();
            $id_visiteur = session("id_visiteur");
            $service->deleteFraisF($id_frais, $id_fraisF, $id_visiteur);

            return redirect("/Frais/modifier/".$id_frais."/forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
