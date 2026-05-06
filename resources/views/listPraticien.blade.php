@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Liste des praticiens</h1>
    </div>

    <form method="POST" action="{{ url('/Praticien/lister') }}" class="resultat-recherche">
        {{ csrf_field() }}
        <p>Recherche : </p>
        <input type="text" value="{{$search}}" name="recherche" class="form-control" placeholder="Rechercher un praticien par nom ou type...">
        <button type="submit" class="btn btn-primary">
            Rechercher
        </button>
    </form>

    @if (isset($searchResult[0]["id_praticien"]))
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse</th>
            <th>Code postal</th>
            <th>Ville</th>
            <th>Coéfficient</th>
            <th>Type</th>
            <th>Lieu</th>
            <th>Spécialités</th>

        </tr>
        </thead>
        <tbody>
        @foreach($searchResult as $ligne)
            <tr>
                <td>{{ $ligne->nom_praticien }}</td>
                <td>{{ $ligne->prenom_praticien }}</td>
                <td>{{ $ligne->adresse_praticien }}</td>
                <td>{{ $ligne->cp_praticien }}</td>
                <td>{{ $ligne->ville_praticien }}</td>
                <td>{{ $ligne->coef_praticien }}</td>
                <td>{{ $ligne->lib_type_praticien }}</td>
                <td>{{ $ligne->lieu_type_praticien }}</td>
                <td><a href="{{url("/Praticien/specialites/".$ligne->id_praticien."/lister")}}">Voir</a></td>
            </tr>
        @endforeach
        </tbody>
        @else
        <div class="container table-message message-tableau-vide">
            <p>Aucun praticien trouvé.</p>
        </div>
        @endif
    </table>
@endsection
