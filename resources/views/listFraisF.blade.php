@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Liste de vos frais au forfait</h1>
    </div>

	<form method="POST" action="{{ url("/Frais/modifier/forfait/ajouter") }}" class="ajout-de-fraisF">
        {{ csrf_field() }}
        <input type="hidden" name="id_frais" class="form-control" value="{{$id_frais}}" required>

        <div class="form-group">
            <label class="col-md-3">Ajouter un frais au forfait : </label>
            <div class="col-md-6">
                <select class="form-select form-control" name="id_fraisF" required>
                    <option value="">--- Sélectionnez un forfait ---</option>
                    @foreach ($lesFraisFNonAttribues as $unFraisF)
                        <option value="{{$unFraisF->id_fraisforfait}}">{{$unFraisF->lib_fraisforfait}}</option>
                    @endforeach
                </select>
				<div> <p>avec la quantité :</p> <input type="number" name="quantite" class="form-control" min="1" value="1"> </div>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Ajouter
            </button>
        </div>
    </form>

    @if (isset($desFraisF[0]["id_fraisforfait"]))
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
				<th>Libellé</th>
                <th>Montant</th>
				<th>Quantité</th>
            </tr>
            </thead>
            <tbody>
            @foreach($desFraisF as $ligne)
                <tr>
					<td>{{ $ligne->lib_fraisforfait }}</td>
                    <td>{{ $ligne->montant_frais_forfait }} @if ($ligne->montant_frais_forfait ==! "") € @if ($ligne->quantite_ligne > 1) (Total : {{$ligne->montant_frais_forfait * $ligne->quantite_ligne}} €) @endif @endif</td>
					<td>{{ $ligne->quantite_ligne }} <a href="{{url("/Frais/modifier/".$id_frais."/forfait/modifier/".$ligne->id_fraisforfait)}}">Changer</a></td>
                </tr>
            @endforeach
            </tbody>
            @else
                <div class="container table-message">
                    <p>Vous n'avez aucun frais au forfait pour ce frais.</p>
                </div>
            @endif
        </table>

		<a href="{{ url("/Frais/modifier/".$id_frais) }}" class="btn btn-secondary">
			Retour
		</a>
@endsection