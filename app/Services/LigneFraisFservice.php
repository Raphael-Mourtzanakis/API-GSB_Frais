<?php

namespace App\Services;

use App\Models\LigneFraisF;
use App\Models\Frais;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;
use function Symfony\Component\String\s;

class LigneFraisFservice
{
	public function saveUnFraisFpourUnFrais(LigneFraisF $ligne_fraisforfait) {
        try {
            $ligne_fraisforfait->save();
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

	public function deleteFraisF($id_frais, $id_fraisforfait, $id_visiteur) {
        try {
            $unFraisF = LigneFraisF::query()
                ->select()
				->where('id_fraisforfait', '=', $id_fraisforfait)
				->where('id_frais', '=', $id_frais)
				->get();

				$visiteurDuFrais = Frais::query() // Pour mettre une erreur si le frais du frais hors forfait n'est pas de notre compte
				->select('id_visiteur')
				->where('id_frais', '=', $id_frais);
				if ($visiteurDuFrais->id_visiteur =! $id_visiteur) {
					throw new UserException(
						"Tu n'as pas accès à ce frais au forfait"
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
