@if(Auth::check())
<header>
    <div class="container-header py-2">
        <nav class="navbar navbar-expand-md px-0">
            <a class="navbar-brand" href="/"><span>R</span>aktár</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Menü megnyitása">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ml-md-3"><a class="nav-link" href="/ertekesites">Értékesítés</a></li>
                    <li class="nav-item ml-md-3"><a class="nav-link" href="/beszerzes">Beszerzés</a></li>
                    <li class="nav-item ml-md-3"><a class="nav-link" href="/cikkek">Cikkek</a></li>
                    <li class="nav-item ml-md-3"><a class="nav-link" href="/raktarak">Raktárak</a></li>
                    <li class="nav-item ml-md-3"><a class="nav-link" href="/felhasznalok">Felhasználók</a></li>
                    <li class="nav-item dropdown ml-md-3">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown02" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">Fiókom</a>
                        <div class="dropdown-menu" aria-labelledby="dropdown01">
                            <a class="dropdown-item" href="/jelszomodositas">Jelszó módosítás</a>
                            <a class="dropdown-item" href="/kilepes">Kilépés</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
@endif
