<?php

namespace App\Services;

use App\Models\Prescrire;
use App\Models\Specialite;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\s;

class PrescrireService
{
	public function classerFamillesDeMedicaments() {
        try {
			$famillesMedoc = Prescrire::query()
                ->select('F.*', DB::raw('COUNT(*) AS nombre_prescription'))
                ->join('medicament as M', 'prescrire.id_medicament', '=', 'M.id_medicament')
                ->join('famille as F', 'F.id_famille', '=', 'M.id_famille')
                ->groupBy('F.id_famille', 'F.lib_famille')
                ->orderBy('nombre_prescription','desc')
                ->orderBy('F.lib_famille')
                ->orderBy('F.id_famille')
            ->get();

			return $famillesMedoc;
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
        SELECT F.*, COUNT(F.lib_famille) AS nombre_prescription
        FROM prescrire P JOIN medicament M
        ON P.id_medicament = M.id_medicament
        JOIN famille F
        ON F.id_famille = M.id_famille
        ORDER BY nombre_prescription DESC, F.lib_famille, F.id_famille
    */

    public function classerPrescriptionsMedicamentsParSpecialite($id_specialite) {
        try {
            $medicaments = Specialite::query()
                ->select(
                    'Med.id_medicament',
                    'Med.nom_commercial',
                    DB::raw('SUM(Stats.quantite) as nombre_prescription')
                )
                ->join('posseder as Pos', 'specialite.id_specialite', '=', 'Pos.id_specialite')
                ->join('praticien as Pra', 'Pos.id_praticien', '=', 'Pra.id_praticien')
                ->join('stats_prescriptions as Stats', 'Pra.id_praticien', '=', 'Stats.id_praticien')
                ->join('medicament as Med', 'Stats.id_medicament', '=', 'Med.id_medicament')
                ->where('specialite.id_specialite', '=', $id_specialite)
                ->groupBy('Med.id_medicament', 'Med.nom_commercial')
                ->orderByDesc('nombre_prescription')
                ->orderBy('Med.nom_commercial')
                ->orderBy('Med.id_medicament')
                ->limit(10)
            ->get();

            return $medicaments;
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
        SELECT
	        Med.id_medicament,
            Med.nom_commercial,
            SUM(Stats.quantite) AS nombre_prescription

        FROM specialite Spe
        JOIN posseder Pos
            ON Spe.id_specialite = Pos.id_specialite
        JOIN praticien Pra
            ON Pos.id_praticien = Pra.id_praticien
        JOIN stats_prescriptions Stats
            ON Pra.id_praticien = Stats.id_praticien
        JOIN medicament Med
            ON Stats.id_medicament = Med.id_medicament

        WHERE Spe.id_specialite = 47

        GROUP BY
        Med.id_medicament,
        Med.nom_commercial

        ORDER BY nombre_prescription DESC, Med.nom_commercial, Med.id_medicament
        LIMIT 10
    */
}
