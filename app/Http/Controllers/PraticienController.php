<?php

namespace App\Http\Controllers;

use App\Models\Praticien;
use App\Models\Specialite;
use App\Models\Posseder;
use App\Services\SpecialiteService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\PraticienService;

class PraticienController extends Controller {
    public function searchPraticien() {
        try {
            return view('formRechercherPraticien');
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function listPraticien(Request $request) {
        try {
            $service = new PraticienService();
            $search = $request->input('recherche');
            $searchResult = $service->getSearchResultPraticien($search);
            return view('listPraticien', compact('searchResult', 'search'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function listSpecialites($id_praticien) {
        try {
            $service = new PraticienService();
            $specialitesDuPraticien = $service->getListSpecialitesDuPraticien($id_praticien);
            $specialitesNonAttribues = $service->getListSpecialitesNonAttribues($id_praticien);
            $praticien = $service->getUnPraticien($id_praticien);
            return view('listSpecialiteDePraticien', compact('specialitesDuPraticien', 'specialitesNonAttribues', 'praticien'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function addSpecialite(Request $request) {
        try {
            $service = new PraticienService();

            $id_praticien = $request->input('id_praticien');

            $posseder = new Posseder();
            $posseder->id_praticien = $id_praticien;
            $posseder->id_specialite = $request->input('id_specialite');

            $service->saveUneSpecialiteDePraticien($posseder);

            return redirect("/Praticien/specialites/".$id_praticien."/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeSpecialite($id_praticien, $id_specialite) {
        try {
            $service = new PraticienService();
            $service->deleteSpecialiteDePraticien($id_praticien, $id_specialite);

            return redirect("/Praticien/specialites/".$id_praticien."/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }





    // Pour les APIs :

    function getPraticienAPI($id) {
        try {
            $service = new PraticienService();
            $praticien = $service->getUnPraticien($id);
            return response()->json([
                'data' => $praticien,
            ]);
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function listPraticienAPI() {
        try {
            $service = new PraticienService();
            $praticiens = $service->getSearchResultPraticien("");
            return response()->json([
                'data' => $praticiens,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function listSpecialitesDunPraticienAPI($id_praticien) {
        try {
            $service = new PraticienService();
            $specialites = $service->getListSpecialitesDuPraticien($id_praticien);
            return response()->json([
                'data' => $specialites,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    function listSpecialitesNonAttribueesAunPraticienAPI($id_praticien) {
        try {
            $service = new PraticienService();
            $specialites = $service->getListSpecialitesNonAttribues($id_praticien);
            return response()->json([
                'data' => $specialites,
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }


    function addSpecialiteAunPraticienAPI(Request $request) {
        try {
            $service = new PraticienService();

            $id_praticien = $request->input('id_praticien');

            $posseder = new Posseder();
            $posseder->id_praticien = $id_praticien;
            $posseder->id_specialite = $request->input('id_specialite');

            $service->saveUneSpecialiteDePraticien($posseder);

            return response()->json([
                'status' => 'Spécialité ajouté au praticien'
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    function removeSpecialiteAunPraticienAPI($id_praticien, $id_specialite) {
        try {
            $service = new PraticienService();

            $service->deleteSpecialiteDePraticien($id_praticien, $id_specialite);
            return response()->json([
                'status' => 'Spécialité supprimée pour ce praticien',
            ]);
        } catch (Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

}
