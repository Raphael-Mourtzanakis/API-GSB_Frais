<?php

namespace App\Services;

use App\Models\Praticien;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;

class PraticienService
{
    public function getSearchResultPraticien($search)
    {
        try {
            $desFrais = Praticien::query()
                ->select()
                ->where(
                    'praticien.nom_praticien', 'LIKE', '%' . $search . '%', 'OR',
                    'type_praticien.lib_type_praticien', 'LIKE', '%' . $search . '%'
                )
                ->join("type_praticien", "type_praticien.id_type_praticien", "=", "praticien.id_type_praticien")
                ->orderBy('praticien.nom_praticien')->orderBy('praticien.prenom_praticien')
                ->get();

            return $desFrais;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
}
