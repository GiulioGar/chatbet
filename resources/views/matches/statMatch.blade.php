@extends('layouts.app')

@section('title', 'Statistiche della Partita')

@section('content')

<style>

.match-header-container {
    width: 100%;
    background-color: #1a1a2e;
    padding: 0.5rem 0;  /* Ridotto padding per avvicinare i contenuti */
    margin-bottom: 1rem;  /* Riduzione del margine inferiore */
}

#match-header {
    display: flex;
    align-items: center;
    justify-content: center;  /* Allineamento centrale per tutte le sezioni */
    max-width: 1200px;  /* Limitare la larghezza massima per un layout compatto */
    margin: 0 auto;  /* Centra il contenitore */
}

.hero-team {
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;  /* Rimuove margini extra */
}

.team-logo {
    margin: 0;  /* Rimuove margini extra attorno al logo */
}

.team-logo img {
   width: 70%;
}
.team-info {
    margin-left: 0.5rem;  /* Margine minimo per separare logo e informazioni */
}

.text-right .team-info {
    margin-right: 0.5rem;  /* Spostare leggermente a destra il testo della squadra ospite */
}

.text-dark { font-size: 15px;}

.form-run-neo {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 0.2rem;  /* Riduzione del margine superiore */
}

.breadcrumb a {
    color: #8899aa;
    text-decoration: none;
    font-size: 1.15rem;  /* Ridotto il font per breadcrumb */
    text-align: center;
}

.breadcrumb a:hover {
    color: #fff;
}

.match-info {
    margin: 0 1rem;  /* Margine ridotto per avvicinare le sezioni */
    text-align: center;
    margin-left: 5%!important;
    margin-right: 5%!important;
}

.match-info h1 {
    color: #fff;
    margin: 0.2rem 0;  /* Riduzione del margine */
    font-size: 1.1rem;  /* Ridotto il font per adattarsi meglio */
}

.scoreline {
    color: #aaa;
    font-size: 0.8rem;
    margin-top: 0.2rem;  /* Riduzione del margine superiore */
}

.form-box {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%; /* Larghezza fissa per il contenitore */
    padding: 5px; /* Padding per gestire lo spazio interno */
    background-color: #eee; /* Sfondo chiaro per visibilità */
    border-radius: 5px; /* Bordo arrotondato per un tocco estetico */
}

.fixed-width {
    min-width: 0.8em;
    max-width: 8.5em;
}

.badge .infopoint {
    font-size: 0.9rem; /* Dimensione del testo all'interno del badge */
    padding: 0.3rem 0.6rem; /* Padding per un badge compatto */
    margin-left: 5px; /* Distanza tra il div e il badge */
}

.hero-team-name { font-size: 1.5em;  font-family: 'Roboto', sans-serif;}

.breadcrumb { padding:2%!important;}

.breadcrumb a {text-transform: uppercase; margin-left: 25%;}


</style>


<div class="match-header-container bg-dark text-white p-3 mb-4">
    <div class="container-fluid">
        <div id="match-header" class="d-flex align-items-center justify-content-center">
            <!-- Squadra Casa -->
            <a href="#" class="hero-team d-flex align-items-center text-white mr-2">
                <div class="team-logo">
                    <img src="https://media.api-sports.io/football/teams/{{ $homeTeam->team_id}}.png" class="img-fluid" alt="{{ $homeTeam->name }} logo">
                </div>
                <div class="team-info ml-2">
                    <span class="hero-team-name mt-1">{{ $homeTeam->name }}</span>
                    <div class="form-box d-flex align-items-center justify-content-center fixed-width">
                        <b><div class="text-dark p-1 mb-1 text-center">{{ $homeTeamPosition }}°</div></b>
                        <span class="badge bg-success text-white ml-2 infopoint">{{ $homeTeam->points }} Punti</span>
                    </div>
                    <div class="form-run-neo d-flex justify-content-end">
                        @foreach($homeTeamLastFive as $result)
                        @if(($result->home_id == $homeTeam->team_id && $result->home_score > $result->away_score) ||
                            ($result->away_id == $homeTeam->team_id && $result->away_score > $result->home_score))
                            <span class="badge badge-success mr-1 last5">W</span>
                        @elseif($result->home_score == $result->away_score)
                            <span class="badge badge-warning mr-1 last5">D</span>
                        @else
                            <span class="badge badge-danger mr-1 last5">L</span>
                        @endif
                    @endforeach
                    </div>
                </div>
            </a>

            <!-- Informazioni sulla Partita -->
            <div class="match-info text-center mx-2">
                <div class="breadcrumb mb-2">
                   <a href="#" class="text-dark"><b>{{ $leagueName }} </b></a>
                </div>
                <div>
                    <time datetime="{{ $match->match_date }}T{{ $match->match_time }}" class="d-block">
                        {{ \Carbon\Carbon::parse($match->match_date)->format('d/m/Y') }} - {{ $match->match_time }}
                    </time>
                    <h1 class="h4">{{ $homeTeam->name }} vs {{ $awayTeam->name }}</h1>
                    <span>Statistiche, previsioni e info</span>
                </div>
                <div class="scoreline mt-1" style="font-size:0.8rem;">Stadio X </div>
            </div>

            <!-- Squadra Ospite -->
            <a href="#" class="hero-team d-flex align-items-center text-white ml-2">
                <div class="team-info text-right mr-2">
                    <span class="hero-team-name mt-1">{{ $awayTeam->name }}</span>
                    <div class="form-box d-flex align-items-center justify-content-center">
                        <div class="text-dark p-1 mb-1 text-center"><b>{{ $awayTeamPosition }}°</b></div>
                        <span class="badge bg-success text-white ml-2 infopoint">{{ $awayTeam->points }} Punti</span>
                    </div>

                    <div class="form-run-neo d-flex justify-content-end">
                        <!-- Badge di esempio per i risultati -->
                        @foreach($awayTeamLastFive as $result)
                        @if(($result->home_id == $awayTeam->team_id && $result->home_score > $result->away_score) ||
                            ($result->away_id == $awayTeam->team_id && $result->away_score > $result->home_score))
                            <span class="badge badge-success mr-1 last5">W</span>
                        @elseif($result->home_score == $result->away_score)
                            <span class="badge badge-warning mr-1 last5">D</span>
                        @else
                            <span class="badge badge-danger mr-1 last5">L</span>
                        @endif
                    @endforeach
                    </div>
                </div>
                <div class="team-logo">
                    <img src="https://media.api-sports.io/football/teams/{{ $awayTeam->team_id}}.png" class="img-fluid" alt="{{ $awayTeam->name }} logo">
                </div>
            </a>
        </div>
    </div>
</div>


<!-- Container centrato per il resto del contenuto della pagina -->
<div class="container resto my-4">
    <!-- Contenuti aggiuntivi -->
    <div class="row">
        <div class="col-md-8">
            <!-- Sezione principale dei contenuti -->
            <div class="card mb-4">
                <div class="card-header">Tutti i Pronostici - Brentford FC vs Southampton FC</div>
                <div class="card-body">
                    <!-- Contenuti dei pronostici -->
                    <p>Statistiche, previsioni e altre informazioni dettagliate sui pronostici della partita.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Sezione laterale per statistiche aggiuntive o classifiche -->
            <div class="card mb-4">
                <div class="card-header">Premier League Classifica</div>
                <div class="card-body">
                    <!-- Contenuti della classifica -->
                    <p>Classifica e statistiche del campionato.</p>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
