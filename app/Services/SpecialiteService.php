<?php

namespace App\Services;

use App\Models\Specialite;
use Illuminate\Database\QueryException;
use App\Exceptions\UserException;

class SpecialiteService
{
    public function getListSpecialites()
    {
        try {
            $specialites = Specialite::query()
                ->select()
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

    public function getUneSpecialite($id) {
        try {
            $unFrais = Specialite::query()
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

    public function saveUneSpecialite(Specialite $specialite) {
        try {
            $specialite->save();
        } catch (QueryException $exception) {
            $userMessage = "Erreur d'accès à la base de données";
            throw new UserException(
                $userMessage,
                $exception->getMessage(),
                $exception->getCode()
            );
        }
    }

    public function deleteSpecialite($id) {
        try {
            $unFrais = Specialite::query()
                ->find($id);
            $unFrais->delete();
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
