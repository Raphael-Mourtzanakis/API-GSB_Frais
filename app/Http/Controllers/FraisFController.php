<?php

namespace App\Http\Controllers;

use App\Models\FraisF;
use App\Models\LigneFraisF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\FraisFService;
use App\Services\LigneFraisFservice;

class FraisFController extends Controller {
    public function listFraisF() {
        try {
            $service = new FraisFService();
            $desFraisF = $service->getListFraisF();
            return view('listFraisF', compact('desFraisF'));
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
            $unFraisF = $service->getUnFraisF($id);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formFraisF', compact('unFraisF', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeFraisF($id) {
        try {
            $service = new FraisFservice();
            $service->deleteFraisF($id);

            return redirect("/Frais_forfait/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }





    // Pour les APIs :

    function getFraisF_API($id) {
        try {
            $service = new FraisFService();
            $unFraisF = $service->getUnFraisF($id);

            if ($unFraisF && isset($unFraisF)) {
                return response()->json([
                    'data' => $unFraisF,
                ]);
            } else {
                return response()->json([
                    'error' => "Frais au forfait inconnu",
                ]);
            }
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function addFraisF_API(Request $request) {
        try {
            $service = new FraisFService();
            $unFraisF = new FraisF();
            $unFraisF->lib_fraisforfait = $request->json('lib_fraisforfait');
            $unFraisF->montant_frais_forfait = $request->json('montant_frais_forfait');
            $service->saveUnFraisF($unFraisF);

            return response()->json([
                'status' => 'Frais au forfait ajouté',
                'data' => $unFraisF,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function listFraisF_API() {
        try {
            $service = new FraisFService();
            $desFraisF = $service->getListFraisF();
            return response()->json([
                'data' => $desFraisF,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function updateFraisF_API(Request $request) {
        try {
            $service = new FraisFService();
            $id = $request->json('id_fraisforfait');
            $unFraisF = $service->getUnFraisF($id);
            $ancienFraisF = $service->getUnFraisF($id);
            $unFraisF->lib_fraisforfait = $request->json('lib_fraisforfait');
            $unFraisF->montant_frais_forfait = $request->json('montant_frais_forfait');

            if ($unFraisF && isset($unFraisF)) {
                $service->saveUnFraisF($unFraisF);

                return response()->json([
                    'status' => 'Frais au forfait modifié',
                    'old_data' => $ancienFraisF,
                    'new_data' => $unFraisF,
                ]);
            } else {
                return response()->json([
                    'error' => "Frais au forfait inconnu",
                ]);
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function removeFraisF_API(Request $request) {
        try {
            $id = $request->json('id_fraisforfait');
            $service = new FraisFService();
            $unFraisF = $service->getUnFraisF($id);

            if ($id && isset($unFraisF)) {
                $service->deleteFraisF($id);
                return response()->json([
                    'status' => 'Frais au forfait supprimé',
                    'data' => $unFraisF,
                ]);
            } else {
                return response()->json([
                    'error' => 'Frais au forfait inconnu',
                ]);
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
