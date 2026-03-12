@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ url('/Praticien/lister') }}">
        {{ csrf_field() }}

        <h1>Rechercher un praticien</h1>
        <div class="col-md-12 card card-body bg-light">
            <div class="form-group">
                <label class="col-md-3">Rechercher</label>
                <div class="col-md-6">
                    <input type="text" name="recherche" class="form-control" placeholder="Rechercher un praticien par nom ou spécialité...">
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        Rechercher
                    </button>
                    <button type="button" class="btn btn-secondary"
                            onclick="if (confirm ('Annuler la recherche ?')) window.location='{{ url('/') }}';">
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
