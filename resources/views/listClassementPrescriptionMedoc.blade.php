@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Classement des familles de médicaments les plus précrits</h1>
    </div>

    @if (isset($famillesMedoc[0]["nombre_prescription"]))
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Famille de médicament</th>
            <th>Nombre de préscription</th>
        </tr>
        </thead>
        <tbody>
        @foreach($famillesMedoc as $ligne)
            <tr>
                <td>{{ $ligne->lib_famille }}</td>
                <td>{{ $ligne->nombre_prescription }}</td>
            </tr>
        @endforeach
        </tbody>
        @else
        <div class="container table-message">
            <p>Aucune famille de médicament trouvée ayant été déjà préscrite.</p>
        </div>
        @endif
    </table>
@endsection
