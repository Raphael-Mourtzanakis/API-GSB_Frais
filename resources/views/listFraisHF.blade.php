@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Liste de vos frais hors forfait</h1>
    </div>

	<a href="{{ url("/Frais/modifier/".$id_frais."/hors-forfait/ajouter") }}" class="btn btn-primary ajout-de-fraisHF">
        Ajouter un frais hors forfait
    </a>

    @if (isset($desFraisHF[0]["id_fraishorsforfait"]))
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Date de modification</th>
                <th>Montant</th>
                <th>Libellé</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($desFraisHF as $ligne)
                <tr>
                    <td>{{ $ligne->date_fraishorsforfait }}</td>
                    <td>{{ $ligne->montant_fraishorsforfait }} @if ($ligne->montant_fraishorsforfait ==! "") € @endif</td>
                    <td>{{ $ligne->lib_fraishorsforfait }}</td>
                    <td><a href="{{url("/Frais/modifier/".$ligne->id_frais."/hors-forfait/modifier/".$ligne->id_fraishorsforfait)}}">Afficher</a></td>
                </tr>
            @endforeach
            </tbody>
            @else
                <div class="container table-message">
                    <p>Vous n'avez aucun frais hors forfait pour ce frais.</p>
                </div>
            @endif
        </table>
        @endsection
