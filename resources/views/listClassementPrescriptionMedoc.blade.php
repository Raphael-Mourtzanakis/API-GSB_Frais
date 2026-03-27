@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Classement des 10 médicaments les plus préscrits par les médecins de la spécialité "{{$specialite->lib_specialite}}"</h1>
    </div>

    @if (isset($medicaments[0]["nombre_prescription"]))
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Nom commercial</th>
            <th>Nombre de prescription</th>
        </tr>
        </thead>
        <tbody>
        @foreach($medicaments as $ligne)
            <tr>
                <td>{{ $ligne->nom_commercial }}</td>
                <td>{{ $ligne->nombre_prescription }}</td>
            </tr>
        @endforeach
        </tbody>
        @else
        <div class="container table-message">
            <p>Aucun médicament trouvé ayant été préscrit par un médecin de cette spécialité.</p>
        </div>
        @endif
    </table>
@endsection
