<?php

namespace App\Http\Controllers;

use App\Models\Specialite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\SpecialiteService;

class SpecialiteController extends Controller {
    public function listSpecialite() {
        try {
            $service = new SpecialiteService();
            $specialites = $service->getListSpecialites();
            return view('listSpecialite', compact('specialites'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function addSpecialite() {
        try {
            $specialite = new Specialite();
			$estPossedee = false;
            return view('formSpecialite', compact('specialite', 'estPossedee'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function validSpecialite(Request $request) {
        try {
            $id = $request->input('id');
            $service = new SpecialiteService();
            if ($id) {
                $specialite = $service->getUneSpecialite($id);
            } else {
                $specialite = new Specialite();
            }
            $specialite->lib_specialite = $request->input("libelle");

            $service->saveUneSpecialite($specialite);

            return redirect("/Specialite/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function editSpecialite($id) {
        try {
            $service = new SpecialiteService();
            $specialite = $service->getUneSpecialite($id);
			$estPossedee = $service->getNombreDeFoisQueLaSpecialiteEstPossedee($id);

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formSpecialite', compact('specialite', 'estPossedee', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeSpecialite($id) {
        try {
            $service = new SpecialiteService();
			$service->removeSpecialiteDeTousLesPraticiens($id);
            $service->deleteSpecialite($id);

            return redirect("/Specialite/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }





    // Pour les APIs :

    function getSpecialiteAPI($id) {
        try {
            $service = new SpecialiteService();
            $specialite = $service->getUneSpecialite($id);

			if ($specialite && isset($specialite)) {
				return response()->json([
                	'data' => $specialite,
            	]);
			} else {
				return response()->json([
                	'error' => "Spécialité inconnue",
            	]);
			}
            
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function addSpecialiteAPI(Request $request) {
        try {
            $service = new SpecialiteService();
            $specialite = new Specialite();
            $specialite->lib_specialite = $request->json('libelle');
            $service->saveUneSpecialite($specialite);

            return response()->json([
                'status' => 'Specialité ajoutée',
                'data' => $specialite,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function listSpecialiteAPI() {
        try {
            $service = new SpecialiteService();
            $specialites = $service->getListSpecialites();
            return response()->json([
                'data' => $specialites,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function updateSpecialiteAPI(Request $request) {
        try {
            $service = new SpecialiteService();
            $id = $request->json('id');

            $specialite = $service->getUneSpecialite($id);
            $ancienneSpecialite = $service->getUneSpecialite($id);
            $specialite->lib_specialite = $request->json('libelle');

            $service->saveUneSpecialite($specialite);

			if ($specialite && isset($specialite)) {
				return response()->json([
					'status' => 'Spécialité modifiée',
					'old_data' => $ancienneSpecialite,
					'new_data' => $specialite,
            	]);
			} else {
				return response()->json([
					'error' => 'Spécialité inconnue'
            	]);
			}
            
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function removeSpecialiteAPI(Request $request) {
        try {
            $id = $request->json('id');
            $service = new SpecialiteService();
            $specialite = $service->getUneSpecialite($id);

            if ($specialite && isset($specialite)) {
                $service->deleteSpecialite($id);
                return response()->json([
                    'status' => 'Spécialité supprimée',
                    'data' => $specialite,
                ]);
            } else {
                return response()->json([
                    'error' => 'Spécialité inconnue',
                ]);
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

	function getNombreDeFoisQueLaSpecialiteEstPossedeeAPI($id) {
        try {
            $service = new SpecialiteService();
            $specialite = $service->getUneSpecialite($id);

            if ($specialite && isset($specialite)) {
                $estPossedee = $service->getNombreDeFoisQueLaSpecialiteEstPossedee($id);
                return response()->json([
                    'nombre' => $estPossedee
                ]);
            } else {
                return response()->json([
                    'error' => 'Spécialité inconnue',
                ]);
            }
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
