<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\PrescrireService;
use App\Services\SpecialiteService;

class PrescrireController extends Controller {
    public function listClassementFamilleMedoc() {
        try {
            $service = new PrescrireService();
            $famillesMedoc = $service->classerFamillesDeMedicaments();

            return view('listClassementFamilleMedoc', compact('famillesMedoc'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function formClassementPrescriptionMedoc() {
        try {
            $service = new SpecialiteService();
            $specialites = $service->getListSpecialites();

            return view('formClassementPrescriptionMedoc', compact('specialites'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }

    public function listClassementPrescriptionMedoc(Request $request) {
        try {
            $request->input('id_specialite');

            $service = new PrescrireService();
            $medicaments = $service->classerPrescriptionsMedicamentsParSpecialite($id_specialite);

            return view('listClassementPrescriptionMedoc', compact('medicaments'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
