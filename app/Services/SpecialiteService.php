<?php

namespace App\Services;

use App\Models\Specialite;
use App\Models\Posseder;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Session;

class SpecialiteService
{
    public function getListSpecialites()
    {
        try {
            $specialites = Specialite::query()
                ->select()
                ->orderBy('lib_specialite')
                ->get();

            return $specialites;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function getUneSpecialite($id) {
        try {
            $unFrais = Specialite::query()
                ->find($id);

            return $unFrais;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function saveUneSpecialite(Specialite $specialite) {
        try {
            $specialite->save();
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function deleteSpecialite($id) {
        try {
            $specialite = Specialite::query()
                ->find($id);
            $specialite->delete();
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
                return redirect(url('Specialite/lister'));
            } else {
                return view('error', compact('exception'));
            }
        }
    }

	public function getNombreDeFoisQueLaSpecialiteEstPossedee($id) {
        try {
            $posseder = Posseder::query()
                ->select()
                ->where('id_specialite', '=', $id)
			->get();
            return count($posseder);
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
                return redirect(url('Specialite/lister'));
            } else {
                return view('error', compact('exception'));
            }
        }
    }

	public function removeSpecialiteDeTousLesPraticiens($id) {
        try {
            $posseder = Posseder::query()
                ->select()
                ->where('id_specialite', '=', $id);
            $posseder->delete();
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
                return redirect(url('Specialite/lister'));
            } else {
                return view('error', compact('exception'));
            }
        }
    }
}
