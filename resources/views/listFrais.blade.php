@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Liste de vos frais</h1>
    </div>

    @if (isset($desFrais[0]["id_frais"]))
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Date de modification</th>
            <th>Mois</th>
            <th>Titre</th>
            <th>État</th>
            <th>Nombre de justificatifs</th>
            <th>Montant validé</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($desFrais as $ligne)
            <tr>
                <td>{{ $ligne->datemodification }}</td>
                <td>{{ $ligne->anneemois }}</td>
                <td>{{ $ligne->titre }}</td>
                <td>{{ $ligne->lib_etat }}</td>
                <td>{{ $ligne->nbjustificatifs }}</td>
                <td>{{ $ligne->montantvalide }} @if ($ligne->montantvalide ==! "") € @endif</td>
                <td><a href="{{url("/editerFrais/".$ligne->id_frais)}}">Afficher</a></td>
            </tr>
        @endforeach
        </tbody>
        @else
        <div class="container table-message">
            <p>Vous n'avez aucun frais.</p>
        </div>
        @endif
    </table>
@endsection
