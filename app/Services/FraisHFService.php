<?php

namespace App\Services;

use App\Models\FraisHF;
use App\Models\Frais;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;
use function Symfony\Component\String\s;

class FraisHFService
{
    public function getListFraisHF($id_frais,$id_visiteur) {
        try {
        $desFraisHF = FraisHF::query()
            ->select()
            ->join('frais', 'frais.id_frais', '=', 'fraishorsforfait.id_frais')
            ->where('fraishorsforfait.id_frais', $id_frais)
            ->orderBy('fraishorsforfait.id_fraishorsforfait')
        ->get();
        $visiteurDuFrais = Frais::query() // Pour mettre une erreur si le frais du frais hors forfait n'est pas de notre compte
            ->select('id_visiteur')
            ->where('id_frais', $id_frais);
        if ($visiteurDuFrais->id_visiteur =! $id_visiteur) {
            throw new UserException(
                "Tu n'as pas accès à ce frais hors forfait"
            );
        } else {
            return $desFraisHF;
        }
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function getUnFraisHF($id) {
        try {
        $unFraisHF = FraisHF::query()
            ->find($id);

        return $unFraisHF;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function saveUnFraisHF(Frais $unFraisHF) {
        try {
        $unFraisHF->save();
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function deleteFraisHF($id,$id_visiteur) {
        try {
            $unFraisHF = FraisHF::query()
                ->find($id);
                if ($unFraisHF->id_visiteur =! $id_visiteur) {
                    throw new UserException(
                        "Tu n'as pas accès à ce frais"
                    );
                } else {
                    $unFraisHF->delete();
                }
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
                return redirect(url('editerFrais/'.$id));
            } else {
                return view('error', compact('exception'));
            }
        }
    }
}
