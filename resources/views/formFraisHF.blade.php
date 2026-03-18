@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ url('/Frais/modifier/hors-forfait/valider') }}">
        {{ csrf_field() }}

        <h1>@if ($unFraisHF->id_fraishorsforfait) Fiche @else Ajout @endif de frais</h1>
        <div class="col-md-12 card card-body bg-light">
            @if ($unFraisHF->id_fraishorsforfait) <input type="hidden" name="id-fraisHF" class="form-control" value="{{$unFraisHF->id_fraishorsforfait}}" required> @endif
			<input type="hidden" name="id-frais" class="form-control" value="{{$id_frais}}" required>

            <div class="form-group">
                <label class="col-md-3">Libellé</label>
                <div class="col-md-6">
                    <input type="text" name="libelle" class="form-control" value="{{$unFraisHF->lib_fraishorsforfait}}" maxlength="200">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Montant</label>
                <div class="col-md-6">
                    <div class="money-group"> <input type="number" name="montant" class="form-control" min="0" step="0.01" value="{{$unFraisHF->montant_fraishorsforfait}}"> € </div>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        @if ($unFraisHF->id_fraishorsforfait) Modifier @else Valider @endif
                    </button>
                    <button type="button" class="btn btn-secondary"
                            @if ($unFraisHF->id_fraishorsforfait) onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url("/Frais/modifier/".$id_frais."/hors-forfait/lister") }}';">
                            @else onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url('/') }}';">
                            @endif
                        Annuler
                    </button>
                    @if ($unFraisHF->id_fraishorsforfait)
                        <a href="{{ url("/Frais/modifier/".$id_frais."/hors-forfait/supprimer/".$unFraisHF->id_fraishorsforfait) }}" id="suppr" class="btn btn-danger" onclick="if (confirm ('Supprimer cette fiche de frais ?'));">
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
