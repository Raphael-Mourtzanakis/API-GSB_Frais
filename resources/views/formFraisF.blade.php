@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ url('/Frais_forfait/valider') }}">
        {{ csrf_field() }}

        <h1>Fiche de frais au forfait</h1>
        <div class="col-md-12 card card-body bg-light">
            @if ($unFraisF->id_fraisforfait) <input type="hidden" name="id" class="form-control" value="{{$unFraisF->id_fraisforfait}}" required> @endif

            <div class="form-group">
                <label class="col-md-3">Libellé</label>
                <div class="col-md-6">
                    <input type="text" name="libelle" class="form-control" value="{{$unFraisF->lib_fraisforfait}}" maxlength="100">
                </div>
            </div>
			<div class="form-group">
                <label class="col-md-3">Montant</label>
                <div class="col-md-6">
                    <div class="money-group"> <input type="number" name="montant" class="form-control" value="{{$unFraisF->montant_frais_forfait}}" step="0.01" min="0"> € </div>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        @if ($unFraisF->id_fraisforfait) Modifier @else Valider @endif
                    </button>
                    <button type="button" class="btn btn-secondary"
                            @if ($unFraisF->id_fraisforfait) onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url("/Frais_forfait/lister") }}';">
                            @else onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url('/') }}';">
                            @endif
                        Annuler
                    </button>
                    @if ($unFraisF->id_fraisforfait)
                        <a href="{{ url("/Frais_forfait/supprimer/".$unFraisF->id_fraisforfait) }}" id="suppr" class="btn btn-danger" onclick="if (confirm ('Supprimer ce frais au forfait de ce frais ?'));">
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
