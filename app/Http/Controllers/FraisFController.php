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
    public function listFraisF() {
        try {
            $service = new FraisFService();
            $unFraisF = $service->getListFraisF();
            return view('listFraisF', compact('unFraisF'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function addFraisF() {
        try {
            $unFraisF = new FraisF();
            return view('formFraisF', compact('unFraisF'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function validFraisF(Request $request) {
        try {
            $id = $request->input('id');
            $service = new FraisFservice();
            if ($id) {
                $unFraisF = $service->getUnFraisF($id);
            } else {
                $unFraisF = new FraisF();
            }
            $unFraisF->lib_fraisforfait = $request->input("libelle");
			$unFraisF->montant_frais_forfait = $request->input("montant");

            $service->saveUnFraisF($unFraisF);

            return redirect("/Frais_forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editFraisF($id) {
        try {
            $service = new FraisFService();
            $unFraisF = $service->getUneSpecialite($id);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formSpecialite', compact('unFraisF', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeFraiF($id) {
        try {
            $service = new FraisFservice();
            $service->deleteFraisF($id);

            return redirect("/Frais_forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
