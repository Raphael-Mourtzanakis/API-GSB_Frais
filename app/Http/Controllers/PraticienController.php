<?php

namespace App\Http\Controllers;

use App\Models\Praticien;
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

    public function searchResultPraticien($search) {
        try {
            $service = new PraticienService();
            $searchResult = $service->getSearchResultPraticien($search);
            return view('listPraticien', compact('searchResult'));
        } catch (Exception $exception) {
            return view('error', compact('exception'));
        }
    }
}
