@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Liste des frais au forfait</h1>
    </div>

    @if (isset($desFraisF[0]["id_fraisforfait"]))
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
				<th>Libellé</th>
                <th>Montant</th>
				<th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($desFraisF as $ligne)
                <tr>
					<td>{{ $ligne->lib_fraisforfait }}</td>
                    <td>{{ $ligne->montant_frais_forfait }} @if ($ligne->montant_frais_forfait ==! "") € @endif</td>
					<td><a href="{{url("/Frais_forfait/modifier/".$id_fraisF)}}">Afficher</a></td>
                </tr>
            @endforeach
            </tbody>
            @else
                <div class="container table-message">
                    <p>Aucun frais au forfait trouvé.</p>
                </div>
            @endif
        </table>

		<a href="{{ url("/Frais_forfait/lister) }}" class="btn btn-secondary">
			Retour
		</a>
@endsection