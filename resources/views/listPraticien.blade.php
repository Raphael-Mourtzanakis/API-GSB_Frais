@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Résultat de recherche de praticien</h1>
    </div>

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
            </tr>
        @endforeach
        </tbody>
        @else
        <div class="container table-message">
            <p>Aucun praticien trouvé.</p>
        </div>
        @endif
    </table>
@endsection
