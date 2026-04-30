<?php

namespace App\Services;

use App\Models\FraisF;
use App\Models\Frais;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;
use function Symfony\Component\String\s;
use Illuminate\Support\Facades\Session;

class FraisFService
{
	public function getListFraisF() {
        try {
			$desFraisF = FraisF::query()
				->select()
				->orderBy('fraisforfait.lib_fraisforfait')->orderBy('fraisforfait.id_fraisforfait')
			->get();

			return $desFraisF;
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

	public function getUnFraisF($id) {
        try {
        $unFraisF = FraisF::query()
			->find($id);

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

    public function deleteFraisF($id) {
        try {
            $unFraisF = FraisF::query()
                ->find($id);
            $unFraisF->delete();
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
                return redirect(url('/Frais_forfait/lister'));
            } else {
              return view('error', compact('exception'));
            }
        }
    }

    public function getListFraisFdunFrais($id_frais, $id_visiteur) {
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
                ->find($id_frais);
            if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé","Tu n'as pas accès à ces frais au forfait"
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

    public function getUnFraisFdunFrais($id_frais, $id_fraisF, $id_visiteur) {
        try {
            $visiteurDuFrais = Frais::query() // Pour mettre une erreur si le frais du frais hors forfait n'est pas de notre compte
                ->select('id_visiteur')
            ->find($id_frais);
            if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé","Tu n'as pas accès à ce frais au forfait"
                );
			} else {
                $unFraisF = FraisF::query()
                    ->select('fraisforfait.*', 'ligne_fraisforfait.quantite_ligne')
                    ->join('ligne_fraisforfait', 'ligne_fraisforfait.id_fraisforfait', '=', 'fraisforfait.id_fraisforfait')
                    ->where('ligne_fraisforfait.id_fraisforfait', '=', $id_fraisF)
                    ->where('ligne_fraisforfait.id_frais', '=', $id_frais)
                ->first();

				return $unFraisF;
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
		WHERE ligne_fraisforfait.id_fraisforfait = 2
	*/

	public function getListFraisFNonAttribues($id_frais, $id_visiteur)
    {
        try {
            $visiteurDuFrais = Frais::query() // Pour mettre une erreur si le frais du frais hors forfait n'est pas de notre compte
                ->select('id_visiteur')
            ->find($id_frais);
            if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé","Tu n'as pas accès à ces frais au forfait"
                );
			} else {
                $lesFraisFNonAttribues = FraisF::whereNotIn('id_fraisforfait', function ($query) use ($id_frais) { // Requête par ChatGPT (mais ça marchait de juste lister tous les spécialités mais on risque une erreur en choisissant une spécialité que le praticien a déjà
                    $query->select('id_fraisforfait')
                        ->from('ligne_fraisforfait')
                        ->where('id_frais', '=', $id_frais);
                })
                    ->orderBy('lib_fraisforfait')->orderBy('id_fraisforfait')
                    ->get();

				return $lesFraisFNonAttribues;
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
}
