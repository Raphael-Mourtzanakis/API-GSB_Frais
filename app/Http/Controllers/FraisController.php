<?php

namespace App\Http\Controllers;

use App\Models\Frais;
use App\Models\FraisF;
use App\Models\LigneFraisF;
use App\Models\Etat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\FraisService;
use App\Services\FraisFservice;
use App\Services\LigneFraisFService;

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
			$service = new FraisService();
			$listEtats = $service->getListEtat();
			$etats = [new Etat()];
			$etats[0]->lib_etat = $listEtats[0]->lib_etat;
            $id_visiteur = session("id_visiteur");
			$montantSaisi = null;

            if (isset($id_visiteur)) {
                return view('formFrais', compact('unFrais', 'montantSaisi', 'etats'));
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
				$unFrais->id_etat = $request->input("etat");
            } else {
                $unFrais = new Frais();
				$unFrais->id_etat = 2;
            }
            $unFrais->anneemois = $request->input("annee-mois");
            $unFrais->id_visiteur = session("id_visiteur");
            $unFrais->nbjustificatifs = $request->input("nb-justificatifs");
            $unFrais->montantvalide = $request->input("montant-validé");

            $service->saveUnFrais($unFrais);

            return redirect("/Frais/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editFrais($id) {
        try {
            $service = new FraisService();
            $etats = $service->getListEtat();
            $unFrais = $service->getUnFrais($id);
			$montantSaisi = $service->getMontantSaisi($id);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formFrais', compact('unFrais', 'etats', 'montantSaisi', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeFrais($id) {
        try {
            $id_visiteur = session("id_visiteur");
            $service = new FraisService();
            $service->deleteFrais($id,$id_visiteur);

            return redirect("/Frais/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

	public function listFraisF($id_frais) {
        try {
            $service = new FraisFservice();
            $id_visiteur = session("id_visiteur");
            $desFraisF = $service->getListFraisFdunFrais($id_frais, $id_visiteur);
			$lesFraisFNonAttribues = $service->getListFraisFNonAttribues($id_frais, $id_visiteur);
            if (isset($id_visiteur)) {
                return view('listFraisFdeFrais', compact('desFraisF', 'id_frais', 'lesFraisFNonAttribues'));
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





    // Pour les APIs :

    function getFraisAPI($id) {
        try {
            $service = new FraisService();
            $unFrais = $service->getUnFrais($id);
            return response()->json([
                'data' => $unFrais,
            ]);
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function addFraisAPI(Request $request) {
        try {
            $service = new FraisService();
            $unFrais = new Frais();
            $unFrais->id_etat = $request->json('id_etat');
            $unFrais->anneemois = $request->json('anneemois');
            $unFrais->id_visiteur = $request->json('id_visiteur');
            $unFrais->nbjustificatifs = $request->json('nbjustificatifs');
            $unFrais->datemodification = today();
            $unFrais->montantvalide = $request->json('montantvalide');
            $service->saveUnFrais($unFrais);

            return response()->json([
                'status' => 'Frais ajouté',
                'data' => $unFrais,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function listFraisAPI($idVisiteur) {
        try {
            $service = new FraisService();
            $desFrais = $service->getListFrais($idVisiteur);
            return response()->json([
                'data' => $desFrais,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function updateFraisAPI(Request $request) {
        try {
            $service = new FraisService();
            $unFrais = $service->getUnFrais($request->json('id_frais'));
            $ancienFrais = $service->getUnFrais($request->json('id_frais'));
            $unFrais->id_etat = $request->json('id_etat');
            $unFrais->anneemois = $request->json('anneemois');
            $unFrais->nbjustificatifs = $request->json('nbjustificatifs');
            $unFrais->datemodification = today();
            $unFrais->montantvalide = $request->json('montantvalide');
            $service->saveUnFrais($unFrais);

            return response()->json([
                'status' => 'Frais modifié',
                'old_data' => $ancienFrais,
                'new_data' => $unFrais,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function removeFraisAPI(Request $request) {
        try {
            $id = $request->json('id_frais');
            $idVisiteur = $request->json('id_visiteur');
            $service = new FraisService();
            $unFrais = $service->getUnFrais($id);

            if ($id && isset($unFrais) && $unFrais->id_visiteur == $idVisiteur) {
                $service->deleteFrais($id, $idVisiteur);
                return response()->json([
                    'status' => 'Frais supprimé',
                    'data' => $unFrais,
                ]);
            } else {
                if ($id && isset($unFrais) && $unFrais->id_visiteur != $idVisiteur) {
                    return response()->json([
                        'error' => "Tu n'as pas accès à ce frais",
                    ]);
                } else {
                    return response()->json([
                        'error' => 'Frais inconnu',
                    ]);
                }
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
