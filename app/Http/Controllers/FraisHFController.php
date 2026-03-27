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
                $unFraisHF = $service->getUnFraisHF($id_fraisHF);
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





    // Pour les APIs :

    function getFraisHF_API($id_fraisHF, $idVisiteur) {
        try {
            $service = new FraisHFService();
            $unFraisHF = $service->getUnFraisHF($id_fraisHF, $idVisiteur);
            return response()->json([
                'data' => $unFraisHF,
            ]);
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function addFraisHF_API(Request $request) {
        try {
            $service = new FraisHFService();
            $unFraisHF = new FraisHF();
            $unFraisHF->id_etat = $request->json('id_etat');
            $unFraisHF->anneemois = $request->json('anneemois');
            $unFraisHF->id_visiteur = $request->json('id_visiteur');
            $unFraisHF->nbjustificatifs = $request->json('nbjustificatifs');
            $unFraisHF->datemodification = today();
            $unFraisHF->montantvalide = $request->json('montantvalide');
            $service->saveUnFraisHF($unFraisHF);

            return response()->json([
                'status' => 'Frais hors forfait ajouté au frais',
                'data' => $unFraisHF,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function listFraisHF_API($id_frais, $idVisiteur) {
        try {
            $service = new FraisHFService();
            $desFraisHF = $service->getListFraisHF($id_frais, $idVisiteur);
            return response()->json([
                'data' => $desFraisHF,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function updateFraisHF_API(Request $request) {
        try {
            $service = new FraisHFService();
            $idFraisHF = $request->json('id_fraishorsforfait');
            $idVisiteur = $request->json('id_visiteur');
            $unFraisHF = $service->getUnFraisHF($idFraisHF, $idVisiteur);
            $ancienFraisHF = $service->getUnFraisHF($idFraisHF, $idVisiteur);
            $unFraisHF->id_frais = $request->json('id_frais');
            $unFraisHF->date_fraishorsforfait = $request->json('date_fraishorsforfait');
            $unFraisHF->montant_fraishorsforfait = $request->json('montant_fraishorsforfait');
            $unFraisHF->lib_fraishorsforfait = $request->json('lib_fraishorsforfait');

            $service->saveUnFraisHF($unFraisHF);

            return response()->json([
                'status' => 'Frais hors forfait modifié',
                'old_data' => $ancienFraisHF,
                'new_data' => $unFraisHF,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function removeFraisHF_API(Request $request) {
        try {
            $idFraisHF = $request->json('id_frais');
            $idVisiteur = $request->json('id_visiteur');
            $service = new FraisHFService();
            $unFraisHF = $service->getUnFraisHF($idFraisHF, $idVisiteur);

            if ($idFraisHF && isset($unFraisHF) && $unFraisHF->id_visiteur == $idVisiteur) {
                $service->deleteFraisHF($idFraisHF, $idVisiteur);
                return response()->json([
                    'status' => 'Frais hors forfait supprimé',
                    'data' => $unFraisHF,
                ]);
            } else {
                if ($idFraisHF && isset($unFraisHF) && $unFraisHF->id_visiteur != $idVisiteur) {
                    return response()->json([
                        'error' => "Tu n'as pas accès à ce frais hors forfait",
                    ]);
                } else {
                    return response()->json([
                        'error' => 'Frais hors forfait inconnu',
                    ]);
                }
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
