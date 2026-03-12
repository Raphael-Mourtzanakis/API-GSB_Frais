@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ url('/Specialite/valider') }}">
        {{ csrf_field() }}

        <h1>@if ($specialite->id_specialite) Fiche @else Ajout @endif de spécialité</h1>
        <div class="col-md-12 card card-body bg-light">
            @if ($specialite->id_specialite) <input type="hidden" name="id" class="form-control" value="{{$specialite->id_specialite}}" required> @endif

            <div class="form-group">
                <label class="col-md-3">Libellé</label>
                <div class="col-md-6">
                    <input type="text" name="libelle" class="form-control" value="{{$specialite->lib_specialite}}" maxlength="100">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        @if ($specialite->id_specialite) Modifier @else Valider @endif
                    </button>
                    <button type="button" class="btn btn-secondary"
                            @if ($specialite->id_specialite) onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url('/Specialite/lister') }}';">
                            @else onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url('/') }}';">
                            @endif
                        Annuler
                    </button>
                    @if ($specialite->id_specialite)
                        <a href="{{ url("/Specialite/supprimer/".$specialite->id_specialite) }}" id="suppr" class="btn btn-danger" onclick="if (confirm ('Supprimer cette spécialité ?'));">
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
