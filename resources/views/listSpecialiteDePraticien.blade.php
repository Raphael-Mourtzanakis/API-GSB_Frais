@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Liste des spécialités du praticien {{$praticien->prenom_praticien}} {{$praticien->nom_praticien}}</h1>
    </div>

    <form method="POST" action="{{ url('/Praticien/specialites/ajouter') }}" class="ajout-de-specialite">
        {{ csrf_field() }}
        <input type="hidden" name="id_praticien" class="form-control" value="{{$praticien->id_praticien}}" required>

        <div class="form-group">
            <label class="col-md-3">Ajouter une spécialité : </label>
            <div class="col-md-6">
                <select class="form-select form-control" name="id_specialite" required>
                    <option value="">--- Sélectionnez une spécialité ---</option>
                    @foreach ($specialitesNonAttribues as $specialite)
                        <option value="{{$specialite->id_specialite}}">{{$specialite->lib_specialite}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Ajouter
            </button>
        </div>
    </form>

    @if (isset($specialitesDuPraticien[0]["id_specialite"]))
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Libellé</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($specialitesDuPraticien as $ligne)
            <tr>
                <td>{{ $ligne->lib_specialite }}</td>
                <td>
                    <a onclick="return confirm('Supprimer cette spécialité de ce praticien ?')"
                       href="{{url("/Praticien/specialites/".$praticien->id_praticien."/supprimer/".$ligne->id_specialite)}}"
                       class="delete-text">
                            Supprimer <i class="bi bi-trash"></i>
                    </a>
            </tr>
        @endforeach
        </tbody>
        @else
        <div class="container table-message">
            <p>Aucune spécialité trouvée pour ce praticien.</p>
        </div>
        @endif
    </table>
    <form method="POST" action="{{ url('/Praticien/lister') }}">
        {{ csrf_field() }}
        <input type="hidden" name="recherche" class="form-control" value="" required>
        <div class="form-group">
            <button type="submit" class="btn btn-secondary">
                Retour
            </button>
        </div>
    </form>
@endsection
