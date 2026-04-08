<?php

namespace App\Services;

use App\Models\Frais;
use App\Models\FraisHF;
use App\Models\LigneFraisF;
use App\Models\Etat;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Session;

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

    public function getUnFrais($id,$id_visiteur) {
        try {
        $unFrais = Frais::query()
            ->find($id);

        if ($unFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
            throw new UserException(
                "Accès refusé", "Tu n'as pas accès à ce frais"
            );
        } else {
            return $unFrais;
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

    public function saveUnFrais(Frais $unFrais, $id_visiteur) {
        try {
            if ($unFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé", "Tu n'as pas accès à ce frais"
                );
            } else {
                $unFrais->save();
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

    public function getListEtat() {
        try {
            $etats = Etat::query()
                ->select()
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

            if ($unFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé","Tu n'as pas accès à ce frais"
                );
            } else {
                $unFrais->delete();
            }
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
                return redirect(url('Frais/modifier/'.$id));
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

	public function getMontantSaisi($id_frais, $id_visiteur) { // Solution trouvée par ChatGPT pour la multiplication de la somme et de la quantité
        try {
            $visiteurDuFrais = Frais::query()
                ->select('id_visiteur')
            ->find($id_frais);
            if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé", "Tu n'as pas accès à ce frais"
                );
            } else {
                $montantSaisiHF = FraisHF::query()
                    ->where('id_frais', '=', $id_frais)
                    ->sum('montant_fraishorsforfait');

                $montantSaisiF = LigneFraisF::query()
                    ->where('id_frais', '=', $id_frais)
                    ->join('fraisforfait', 'ligne_fraisforfait.id_fraisforfait', '=', 'fraisforfait.id_fraisforfait')
                    ->selectRaw('SUM(fraisforfait.montant_frais_forfait * ligne_fraisforfait.quantite_ligne) as total')
                    ->value('total');

                return $montantSaisiHF + $montantSaisiF;
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

	public function removeTousLesFraisHF($id, $id_visiteur) {
        try {
			$visiteurDuFrais = Frais::query()
				->select('id_visiteur')
            ->find($id);

			if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
				throw new UserException(
					"Accès refusé", "Tu n'as pas accès à ce frais"
				);
			} else {
				$desFraisHF = FraisHF::query()
                	->select()
                	->where('id_frais', '=', $id);
            	$desFraisHF->delete();
			}
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
                return redirect(url('Specialite/lister'));
            } else {
                return view('error', compact('exception'));
            }
        }
    }

	public function removeTousLesFraisFduFrais($id, $id_visiteur) {
        try {
            $visiteurDuFrais = Frais::query()
				->select('id_visiteur')
            ->find($id);

			if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
				throw new UserException(
					"Accès refusé", "Tu n'as pas accès à ce frais"
				);
			} else {
				$desFraisF = LigneFraisF::query()
                	->select()
                	->where('id_frais', '=', $id);
            	$desFraisF->delete();
			}
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
