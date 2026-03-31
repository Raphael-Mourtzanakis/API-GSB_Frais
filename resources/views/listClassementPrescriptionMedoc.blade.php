@extends('layouts.master')

@section('content')

    <div class="container">
        <h1>Classement des 10 médicaments les plus préscrits par les médecins de la spécialité :</h1>
        <h2 class="sous-titre">{{$specialite->lib_specialite}}</h2>
    </div>

    <form method="POST" action="{{ url('/Classement/prescription_medicaments/lister') }}" class="menu-deroulant-mini-formulaire">
        {{ csrf_field() }}

        <div class="form-group">
            <label class="col-md-3">Spécialité : </label>
            <div class="col-md-6">
                <select class="form-select form-control" name="id_specialite" required>
                    @foreach ($specialites as $ligneSpecialite)
                        <option value="{{$ligneSpecialite->id_specialite}}" @if ($specialite->id_specialite === $ligneSpecialite->id_specialite)selected @endif>{{$ligneSpecialite->lib_specialite}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                Afficher
            </button>
        </div>
    </form>

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
        <div class="container table-message message-tableau-vide">
            <p>Aucun médicament trouvé ayant été préscrit par un médecin de cette spécialité.</p>
        </div>
        @endif
    </table>
@endsection
