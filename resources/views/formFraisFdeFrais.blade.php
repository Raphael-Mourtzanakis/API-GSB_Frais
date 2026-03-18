@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ url('/Frais/modifier/forfait/valider') }}">
        {{ csrf_field() }}

        <h1>Fiche de frais au forfait d'un frais</h1>
        <div class="col-md-12 card card-body bg-light">
            <!-- <input type="hidden" name="id-fraisF" class="form-control" value="{{$unFraisF->id_fraisforfait}}" required> -->
			<input type="hidden" name="id-frais" class="form-control" value="{{$id_frais}}" required>

            <div class="form-group">
                <label class="col-md-3">Libellé</label>
                <div class="col-md-6">
                    <input type="text" class="form-control" value="{{$unFraisF->lib_fraisforfait}}" disabled>
                </div>
            </div>
			<div class="form-group">
                <label class="col-md-3">Montant</label>
                <div class="col-md-6">
                    <div class="money-group"> <input type="number" class="form-control" value="{{$unFraisF->montant_frais_forfait}}" disabled> € </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Quantité</label>
                <div class="col-md-6">
                    <div class="money-group"> <input type="number" name="quantite" class="form-control" min="1" value="{{$unFraisF->quantite_ligne}}"> </div>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        Modifier
                    </button>
                    <button type="button" class="btn btn-secondary"
                            @if ($unFraisF->id_fraisforfait) onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url("/Frais/modifier/".$id_frais."/forfait/lister") }}';">
                            @else onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url('/') }}';">
                            @endif
                        Annuler
                    </button>
                    @if ($unFraisF->id_fraisforfait)
                        <a href="{{ url("/Frais/modifier/".$id_frais."/forfait/supprimer/".$unFraisF->id_fraisforfait) }}" id="suppr" class="btn btn-danger" onclick="if (confirm ('Supprimer ce frais au forfait de ce frais ?'));">
                            Supprimer
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    @if(isset($erreur))
        <div class="alert alert-danger from-error" role="alert">{{ $erreur }}</div>
    @endif
@endsection
