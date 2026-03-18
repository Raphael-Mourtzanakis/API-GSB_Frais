<?php

namespace App\Services;

use App\Models\FraisF;
use App\Models\Frais;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;
use function Symfony\Component\String\s;

class FraisFService
{
    public function getListFraisF($id_frais, $id_visiteur) {
        try {
        $desFraisF = FraisF::query()
            ->select('fraisforfait.*', 'ligne_fraisforfait.quantite_ligne')
			->join('ligne_fraisforfait', 'ligne_fraisforfait.id_fraisforfait', '=', 'fraisforfait.id_fraisforfait')
            ->join('frais', 'ligne_fraisforfait.id_frais', '=', 'frais.id_frais')
            ->where('ligne_fraisforfait.id_frais', '=', $id_frais)
            ->orderBy('fraisforfait.lib_fraisforfait')->orderBy('fraisforfait.id_fraisforfait')
        ->get();
        $visiteurDuFrais = Frais::query() // Pour mettre une erreur si le frais du frais hors forfait n'est pas de notre compte
            ->select('id_visiteur')
            ->where('id_frais', '=', $id_frais);
        if ($visiteurDuFrais->id_visiteur !== $id_visiteur) {
            throw new UserException(
                "Tu n'as pas accès à ce frais hors forfait"
            );
        } else {
            return $desFraisF;
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
	/* En SQL :
		SELECT fraisforfait.*, ligne_fraisforfait.quantite_ligne
		FROM fraisforfait JOIN ligne_fraisforfait
		ON ligne_fraisforfait.id_fraisforfait = fraisforfait.id_fraisforfait
		JOIN frais
		ON ligne_fraisforfait.id_frais = frais.id_frais
		WHERE ligne_fraisforfait.id_frais = 1
		ORDER BY fraisforfait.lib_fraisforfait, fraisforfait.id_fraisforfait
	*/

    public function getUnFraisF($id_fraisF) {
        try {
        $unFraisF = FraisF::query()
			->select('fraisforfait.*', 'ligne_fraisforfait.quantite_ligne')
            ->join('ligne_fraisforfait', 'ligne_fraisforfait.id_fraisforfait', '=', 'fraisforfait.id_fraisforfait')
            ->where('ligne_fraisforfait.id_fraisforfait', '=', $id_fraisF)
            ->get();

        return $unFraisF;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }
	/* En SQL :
		SELECT fraisforfait.*, ligne_fraisforfait.quantite_ligne
		FROM fraisforfait JOIN ligne_fraisforfait
		ON ligne_fraisforfait.id_fraisforfait = fraisforfait.id_fraisforfait
		WHERE ligne_fraisforfait.id_fraisforfait = 2
	*/

    public function saveUnFraisF(FraisF $unFraisF) {
        try {
        $unFraisF->save();
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function deleteFraisF($id,$id_visiteur) {
        try {
            $unFraisF = FraisF::query()
                ->find($id);
                if ($unFraisF->id_visiteur =! $id_visiteur) {
                    throw new UserException(
                        "Tu n'as pas accès à ce frais"
                    );
                } else {
                    $unFraisF->delete();
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
