@extends('layouts.master')

@section('content')
    <div>
        <h1 style="margin-bottom: 50px;">Authentification</h1>

        <form method="POST" action="{{ url('/authentifier') }}">
            {{ csrf_field() }}

            <div class="col-md-12 card card-body bg-light contenu-formulaire">
                <div class="form-group">
                    <label class="col-md-3">Identifiant : </label>
                    <div class="col-md-6">
                        <input type="text" name="login" value="" class="form-control" placeholder="Votre identifiant" required></div>
                </div>
                <div class="form-group">
                    <label class="col-md-3">Mot de passe : </label>
                    <div class="col-md-6">
                        <input type="password" name="password" value="" class="form-control" placeholder="Votre mot de passe" required>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">
                            Se connecter
                        </button>
                        <button type="button" class="btn btn-secondary"
                                onclick="if (confirm ('Annuler la connexion ?')) window.location='{{ url('/') }}';">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @if (isset($erreur))
            <div class="alert alert-danger" role="alert" style="margin-top: 15px;">
                {{$erreur}}
            </div>
        @endif
    </div>
@endsection
