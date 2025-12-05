<?php

namespace App\Services;

use App\Models\Frais;
use App\Models\Etat;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;

class FraisService
{
    public function getListFrais($id_visiteur) {
        try {
        $desFrais = Frais::query()
            ->select()
            ->where('id_visiteur', $id_visiteur)
            ->join("etat", "etat.id_etat","=","frais.id_etat")
            ->orderBy('datemodification','desc')->orderBy('id_frais','desc')
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

    public function getUnFrais($id) {
        try {
        $unFrais = Frais::query()
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

    public function saveUnFrais(Frais $unFrais) {
        try {
        $unFrais->save();
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function getListEtat() {
        try {
            $etats = Frais::query()
                ->from('etat')
                ->orderBy('lib_etat')
                ->get();

            return $etats;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function deleteFrais($id,$id_visiteur) {
        try {
            $unFrais = Frais::query()
                ->find($id);
                //->where('id_visiteur', $id_visiteur); // Au cas où on n'est pas le visiteur du frais
                if ($unFrais->id_visiteur =! $id_visiteur) {
                    throw new UserException(
                        "Tu n'as pas accès à ce frais"
                    );
                } else {
                    $unFrais->delete();
                }
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
                return redirect(url('editerFrais/'.$id));
                //$userMessage = "Impossible de supprimer une fiche avec des frais saisis";
            } else {
                return view('error', compact('exception'));
                //$userMessage = "Erreur d'accès à la base de données";
            }
            /*throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );*/
        }
    }
}
