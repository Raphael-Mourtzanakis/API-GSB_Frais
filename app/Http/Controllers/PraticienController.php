<?php

namespace App\Http\Controllers;

use App\Models\Praticien;
use App\Models\Specialite;
use App\Models\Posseder;
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
            $specialites = $service->getListSpecialites($id_praticien);
            return view('listSpecialite', compact('specialites'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function addSpecialite($id_praticien) { // Faire un formulaire avec une liste déroulante de spécialités qu'on choisit puis on clique sur ajouter pour l'ajouter à la liste des spécialités du praticien (ou sinon, mettre ce formulaire dans la page de la liste des spécialités)
        try {
            $specialite = new Specialite();
            return view('formSpecialiteDePraticien', compact('specialite', 'id_praticien'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
