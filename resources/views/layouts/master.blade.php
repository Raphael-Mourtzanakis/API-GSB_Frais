<!doctype html>
<html lang="fr">

<head>
    <title>GSB Frais</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/assets/icons/bootstrap-icons.css"/>
    <script> src="/assets/js/bootstrap.bundle.min.js" </script>
    <link rel="stylesheet" href="/assets/css/gsb.css"/>
</head>

<body class="body">
<div>
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">GSB Frais</a>
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                @if(session("id_visiteur"))

                <div class="nav-item_group">

                    <div class="nav-category">
                        <span class="nav-title">Frais</span>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/Frais/lister') }}">Lister</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/Frais/ajouter') }}">Ajouter</a>
                            </li>
                        </ul>
                    </div>

                    <div class="nav-category">
                        <span class="nav-title">Praticien</span>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/Praticien/rechercher') }}">Rechercher</a>
                            </li>
                        </ul>
                    </div>

                    <div class="nav-category">
                        <span class="nav-title">Spécialité</span>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/Specialite/lister') }}">Lister</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/Specialite/ajouter') }}">Ajouter</a>
                            </li>
                        </ul>
                    </div>

                </div>

                <ul class="navbar-nav ms-auto">
                    <b class="nav-text">{{session('visiteur')}}</b>
                    <span class="nav-sepration"></span>
                    <li class="nav-item logout-button">
                        <a class="nav-link" style="cursor: pointer;"
                           onclick="
                           if (confirm ('Êtes vous sûr de vouloir vous déconnecter ?')) {
                               window.location='{{ url('/deconnecter') }}';
                           }"
                        >
                            Se déconnecter
                        </a>
                    </li>
                </ul>

                @else
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item login-button">
                        <a class="nav-link" href="{{ url('/connecter') }}">Se connecter</a>
                    </li>
                </ul>
                @endif

            </div>
        </div>
    </nav>

</div>
<div class="container website-page" style="margin-top: 75px; margin-bottom: 75px;">
    @yield('content')
</div>

</body>

</html>
