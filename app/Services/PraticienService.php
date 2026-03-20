<?php

namespace App\Services;

use App\Models\Praticien;
use App\Models\Specialite;
use App\Models\Posseder;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;

class PraticienService
{
    public function getSearchResultPraticien($search)
    {
        try {
            $praticiens = Praticien::query()
                ->select()
                ->where('praticien.nom_praticien', 'LIKE', '%'.$search.'%')
                ->orWhere('type_praticien.lib_type_praticien', 'LIKE', '%'.$search.'%')
                ->join("type_praticien", "type_praticien.id_type_praticien", "=", "praticien.id_type_praticien")
                ->orderBy('praticien.nom_praticien')->orderBy('praticien.prenom_praticien')
                ->get();

            return $praticiens;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function getUnPraticien($id)
    {
        try {
            $praticien = Praticien::query()
                ->find($id);

            return $praticien;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function getListSpecialitesNonAttribues($id_praticien)
    {
        try {
            $specialites = Specialite::whereNotIn('id_specialite', function ($query) use ($id_praticien) { // Requête par ChatGPT (mais ça marchait de juste lister tous les spécialités mais on risque une erreur en choisissant une spécialité que le praticien a déjà
                $query->select()
                    ->from('posseder')
                    ->where('id_praticien', '=', $id_praticien);
            })
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

    public function getListSpecialitesDuPraticien($id_praticien)
    {
        try {
            $specialites = Specialite::query()
                ->select()
                ->where('posseder.id_praticien', '=', $id_praticien)
                ->join("posseder", "specialite.id_specialite", "=", "posseder.id_specialite")
                ->orderBy('specialite.lib_specialite')
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

    public function saveUneSpecialiteDePraticien(Posseder $posseder) {
        try {
            $posseder->save();
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function deleteSpecialiteDePraticien($id_praticien,$id_specialite) {
        try {
            $posseder = Posseder::query()
                ->select()
                ->where('id_praticien', '=', $id_praticien)
                ->where('id_specialite', '=', $id_specialite);
            $posseder->delete();
        } catch (QueryException $exception) {
            return view('error', compact('exception'));
        }
    }
}
