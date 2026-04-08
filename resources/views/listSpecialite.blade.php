@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Liste des spécialités</h1>
    </div>

	<a href="{{ url("/Specialite/ajouter") }}" class="btn btn-primary bouton-ajout">
        Ajouter une spécialité
    </a>

    @if (isset($specialites[0]["id_specialite"]))
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Libellé</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($specialites as $ligne)
            <tr>
                <td>{{ $ligne->lib_specialite }}</td>
                <td><a href="{{url("/Specialite/modifier/".$ligne->id_specialite)}}">Afficher</a></td>
            </tr>
        @endforeach
        </tbody>
        @else
        <div class="container table-message message-tableau-vide">
            <p>Aucune spécialité trouvée.</p>
        </div>
        @endif
    </table>
@endsection
