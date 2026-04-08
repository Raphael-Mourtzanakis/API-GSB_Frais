<?php

namespace App\Services;

use App\Models\LigneFraisF;
use App\Models\Frais;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;
use function Symfony\Component\String\s;
use Illuminate\Support\Facades\Session;

class LigneFraisFservice
{
	public function ajouterUnFraisFpourUnFrais(LigneFraisF $ligne_fraisforfait, $id_visiteur) {
        try {
            $visiteurDuFrais = Frais::query()
                ->select('id_visiteur')
            ->find($ligne_fraisforfait->id_frais);
            if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé", "Tu ne peux pas ajouter de frais au forfait à ce frais"
                );
            } else {
                $ligne_fraisforfait->save();
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

	public function modifierUnFraisFpourUnFrais(LigneFraisF $ligne_fraisforfait, $id_visiteur) { // Solution pour que ça marche trouvée par ChatGPT, ça ne marchait pas avec save()
        try {
            $visiteurDuFrais = Frais::query()
                ->select('id_visiteur')
                ->find($ligne_fraisforfait->id_frais);
            if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé", "Tu ne peux pas modifier le frais au forfait de ce frais"
                );
            } else {
                LigneFraisF::where('id_frais', $ligne_fraisforfait->id_frais)
                    ->where('id_fraisforfait', $ligne_fraisforfait->id_fraisforfait)
                    ->update([
                        'quantite_ligne' => $ligne_fraisforfait->quantite_ligne
                    ]);
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

	public function deleteFraisFpourUnFrais($id_frais, $id_fraisF, $id_visiteur) {
        try {
            $visiteurDuFrais = Frais::query()
                ->select('id_visiteur')
                ->find($id_frais);
            if ($visiteurDuFrais->id_visiteur != $id_visiteur) { // Ne pas mettre !== ou === pour vérifier ces 2 valeurs, mais != ou == (là != du coup)
                throw new UserException(
                    "Accès refusé", "Tu n'as pas accès à ce frais au forfait"
                );
            } else {
                $unFraisF = LigneFraisF::query()
                    ->select()
                    ->where('id_fraisforfait', '=', $id_fraisF)
                    ->where('id_frais', '=', $id_frais);
                $unFraisF->delete();
            }
        } catch (QueryException $exception) {
            if ($exception->getCode() == 23000) {
                Session::put('erreur', $exception->getMessage());
            } else {
                return view('error', compact('exception'));
            }
        }
    }
}
