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
            return view('formSpecialite', compact('specialite'));
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

            $erreur = Session::get('erreur');
            Session::remove('erreur');

            return view('formSpecialite', compact('specialite', 'erreur'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function removeSpecialite($id) {
        try {
            $service = new SpecialiteService();
            $service->deleteSpecialite($id);

            return redirect("/Specialite/lister");
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
