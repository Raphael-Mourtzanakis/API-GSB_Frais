@extends('layouts.master')

@section('content')
    <form method="POST" action="{{ url('/validerFrais') }}">
        {{ csrf_field() }}

        <h1>@if ($unFrais->id_frais) Fiche @else Ajout @endif de frais</h1>
        <div class="col-md-12 card card-body bg-light">
            @if ($unFrais->id_frais) <input type="hidden" name="id" class="form-control" value="{{$unFrais->id_frais}}" required> @endif

            <div class="form-group">
                <label class="col-md-3">Titre</label>
                <div class="col-md-6">
                    <input type="text" name="titre" class="form-control" value="{{$unFrais->titre}}" maxlength="50">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Année-Mois</label>
                <div class="col-md-6">
                    <input type="month" name="annee-mois" class="form-control" value="{{$unFrais->anneemois}}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Montant saisi</label>
                <div class="col-md-6">
                    <input type="number" name="montant-saisi" class="form-control " min="0" step="0.01" value="" disabled style="cursor: not-allowed">
                    <div class="col-md-12 col-md-offset-3" style="margin-top: 8px; @if (!$unFrais->id_frais) cursor: not-allowed; @endif">
                        <a href="{{ url('listerFraisHF/'.$unFrais->id_frais) }}" class="btn btn-info @if (!$unFrais->id_frais) disabled @endif">Frais hors forfait</a>
                        <a href="" class="btn btn-info @if (!$unFrais->id_frais) disabled @endif">Frais au forfait</a>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Nombre de justificatifs</label>
                <div class="col-md-6">
                    <input type="number" name="nb-justificatifs" class="form-control" min="0" value="{{$unFrais->nbjustificatifs}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">Montant validé</label>
                <div class="col-md-6">
                    <input type="number" name="montant-validé" class="form-control" min="0" step="0.01" value="{{$unFrais->montantvalide}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">État</label>
                <div class="col-md-6">
                    <select class="form-select form-control" name="etat" @if ($unFrais->id_frais)) required @else disabled style="cursor: not-allowed;" @endif>
                        @foreach ($etats as $etat)
                            <option value="{{$etat->id_etat}}" @if ($unFrais->id_etat == $etat->id_etat) selected @endif>{{$etat->lib_etat}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="col-md-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">
                        @if ($unFrais->id_frais) Modifier @else Valider @endif
                    </button>
                    <button type="button" class="btn btn-secondary"
                            @if ($unFrais->id_frais) onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url('/listerFrais') }}';">
                            @else onclick="if (confirm ('Annuler la saisie ?')) window.location='{{ url('/') }}';">
                            @endif
                        Annuler
                    </button>
                    @if ($unFrais->id_frais)
                        <a href="{{ url("/supprimerFrais/".$unFrais->id_frais) }}" id="suppr" class="btn btn-danger" onclick="if (confirm ('Supprimer cette fiche de frais ?'));">
                            Supprimer
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>

    @if(isset($erreur))
        <div class="alert alert-danger from-error" role="alert">{{ $erreur }}</div>
    @endif
@endsection
