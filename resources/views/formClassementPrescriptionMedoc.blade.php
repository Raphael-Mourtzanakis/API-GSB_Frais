@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ url('/Classement/prescription_medicaments/lister') }}">
        {{ csrf_field() }}

        <h1>Classement des médicaments les plus préscrits par les médecins d'une spécialité</h1>
        <div class="col-md-12 card card-body bg-light">
            <div class="form-group">
                <label class="col-md-3">Spécialité</label>
                <div class="col-md-6">
                    <select class="form-select form-control" name="id_specialite" required>
                        <option value="">--- Sélectionnez une spécialité ---</option>
                        @foreach ($specialites as $specialite)
                            <option value="{{$specialite->id_specialite}}">{{$specialite->lib_specialite}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        Afficher
                    </button>
                    <button type="button" class="btn btn-secondary"
                            onclick="if (confirm ('Annuler l\'affichage du classement ?')) window.location='{{ url('/') }}';">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if(isset($erreur))
        <div class="alert alert-danger from-error" role="alert">{{ $erreur }}</div>
    @endif
@endsection
