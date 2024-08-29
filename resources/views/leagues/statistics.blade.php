@extends('layouts.app')

@section('title', 'Statistiche della Lega')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >


<style>

 .container {
    margin-top: 20px;
}
    .container-custom {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .league-info {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f1f1f1;
        margin-bottom: 10px;
    }
    .overview-buttons {
        margin-top: 10px;
        display: flex;
        gap: 10px;
    }
    .fixtures-list {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f1f1f1;
        font-size: 12px;
    }
    .table-custom {
        margin-bottom: 0;
    }
    .badge-custom {
        padding: 5px;
        border-radius: 4px;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-warning {
        background-color: #ffc107;
    }
    .badge-danger {
        background-color: #dc3545;
    }

table.matches-table {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}

table.matches-table thead {
  background: #ddd!important;
  width: 100%;
  font-size: 9px;
}

.matches-table td {padding: .1rem!important; }
.matches-table td img {width: 25% }

.form-run {
    display: flex;
    list-style-type: none;
    padding: 0;
    margin: 0;

}

.form-run li {
    width: 20px;
    height: 20px;
    margin-right: 1px;
    text-align: center;
    line-height: 18px;
    color: white;
    font-weight: bold;
    position: relative;
    border-radius: 5px;
}

.hover-modal-parent {
    position: relative;
}

.hover-modal-content {
    display: none;
    position: absolute;
    top: 30px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 100;
    width: auto;
    min-width: 300px;
    max-width: 90%;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    color: #333;
    transition: opacity 0.3s ease;
    opacity: 0;
    box-sizing: border-box;
    overflow-y: auto;
    text-align: center; /* Centrare il testo orizzontalmente */
}

.hover-modal-parent:hover .hover-modal-content {
    display: block;
    opacity: 1;
}

/* Stili personalizzati per la tabella */
.custom-table {
    width: 100%;
    border-collapse: collapse;
    text-align: center; /* Centrare il testo all'interno della tabella */
}

.custom-table th, .custom-table td {
    padding: 10px;
    text-align: center; /* Centrare il testo nelle celle */
    border-bottom: 1px solid #ddd;
}

.custom-table th {

    font-weight: bold;
}

/* Larghezza fissa per le colonne dei nomi delle squadre */
.custom-team-name {
    font-weight: bold;
    width: 35%; /* Larghezza fissa per le colonne delle squadre */
}

.custom-score {
    width: 30%;
    text-align: center; /* Centra il testo orizzontalmente */
    vertical-align: middle; /* Centra il testo verticalmente */
    font-size: 25px;
    padding-top: 10px; /* Aggiungi spazio sopra il testo per abbassarlo */
}

.custom-score span {
    display: inline-block;
    width: 100%;
    text-align: center;
    margin-top: 10px; /* Aggiungi un margine superiore per abbassare il testo */
}


.custom-mid-small {
    font-size: 12px;
    color: #555;
    text-align: center; /* Centrare testo delle note */
}

@media (max-width: 576px) {
    .hover-modal-content {
        top: 10px;
        padding: 15px;
        font-size: 12px;
        max-height: 80vh;
        text-align: center; /* Assicurare che il testo sia centrato anche su mobile */
    }
}


</style>

<!-- Container Principale -->
<div class="container">
    <div class="row">

        <!-- Colonna Sinistra: Logo e Informazioni -->
        <div class="col-md-4">
            <div class="container-custom">
                <img src="https://via.placeholder.com/100x100" alt="Serie A Logo" class="img-fluid mb-3">
                <div class="league-info">
                    <p><strong>Campionato:</strong><span style=" text-transform:uppercase;"> <b>{{ $leagueName }}</b></span> </p>
                    <p><strong>Teams:</strong> {{ $teamCount }}</p>
                    <p><strong>Stagione:</strong> 2024/25</p>
                    <p><strong>Partite:</strong> {{ $playMatches }}/ {{ $totalMatches }} Giocate</p>
                    <p><strong>Avanzamento:</strong> <b>{{ $percMatches }}</b>% completato</p>
                </div>
                <div class="overview-buttons">
                    <button class="btn btn-primary btn-sm">Overview</button>
                    <button class="btn btn-outline-secondary btn-sm">Fixtures</button>
                    <button class="btn btn-outline-secondary btn-sm">Detailed Stats</button>
                </div>
            </div>
        </div>

        <!-- Colonna Destra: Fixtures -->
        <div class="col-md-8">
            <div class="container-custom">
                <h6>Prossime partite  {{ $leagueName }}</h6>
                @if($nextMatches->isEmpty())
                    <p>Nessuna partita programmata al momento.</p>
                @else
                    <table class="table table-striped matches-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Orario</th>
                                <th colspan="5">&nbsp;</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nextMatches as $match)
                                <tr>
                                    <td>{{ $match->formatted_date }}</td>
                                    <td>{{ $match->formatted_time }}</td>
                                    <td>
                                        <ul class="form-run">
                                            @foreach($match->home_last_five as $result)
                                                <li class="form-run {{ $result->result }} hover-modal-parent">
                                                    <a class="form-run-box" href="#">{{ $result->resultLogo }}</a>
                                                    <div class="hover-modal-parent">
                                                        <!-- Elemento che attiva la modale -->


                                                        <!-- Contenuto della modale dinamico -->
                                                        <div class="hover-modal-content">
                                                            <table class="custom-table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="3">{{ $result->match_date }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="custom-team-name"><div><img src='https://media.api-sports.io/football/teams/{{ $result->homeTeam->team_id}}.png'></div>{{ $result->homeTeam->name }}</td>
                                                                        <td class="custom-score"><span>{{ $result->home_score }} - {{ $result->away_score }}</span></td>
                                                                        <td class="custom-team-name"><div><img src='https://media.api-sports.io/football/teams/{{ $result->awayTeam->team_id}}.png'></div>{{ $result->awayTeam->name }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td> {{ $match->homeTeam->name ?? 'N/A' }}</td>
                                    <td> {{ $match->awayTeam->name ?? 'N/A' }}</td>
                                    <td>
                                        <ul class="form-run">
                                            @foreach($match->away_last_five as $result)
                                                <li class="form-run {{ $result->result }} hover-modal-parent">
                                                    <a class="form-run-box" href="#">{{ $result->resultLogo }}</a>
                                                    <div class="hover-modal-parent">
                                                        <!-- Elemento che attiva la modale -->


                                                        <!-- Contenuto della modale dinamico -->
                                                        <div class="hover-modal-content">
                                                            <table class="custom-table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th colspan="3">{{ $result->match_date }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="custom-team-name"><div><img src='https://media.api-sports.io/football/teams/{{ $result->homeTeam->team_id}}.png'></div>{{ $result->homeTeam->name }}</td>
                                                                        <td class="custom-score"><span>{{ $result->home_score }} - {{ $result->away_score }}</span></td>
                                                                        <td class="custom-team-name"><div><img src='https://media.api-sports.io/football/teams/{{ $result->awayTeam->team_id}}.png'></div>{{ $result->awayTeam->name }}</td>
                                                                    </tr>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td><a href="#" class="btn btn-sm btn-link">Stats</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>

    <!-- Seconda Riga: Classifica -->
    <div class="row">
        <div class="col-md-9">
            <div class="container-custom">
                <h4>Classifica  {{ $leagueName }} - 2024/25</h4>
                <table class="table table-striped table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Squadra</th>
                            <th>Partite</th>
                            <th>V</th>
                            <th>P</th>
                            <th>S</th>
                            <th>GF</th>
                            <th>GS</th>
                            <th>DR</th>
                            <th>PUN</th>
                            <th>ANDAMENTO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Juventus FC</td>
                            <td>2</td>
                            <td>2</td>
                            <td>0</td>
                            <td>0</td>
                            <td>6</td>
                            <td>0</td>
                            <td>+6</td>
                            <td>6</td>
                            <td><span class="badge badge-success badge-custom">W</span> <span class="badge badge-success badge-custom">W</span></td>
                        </tr>
                        <!-- Altre righe di squadre -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-3">
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script>
    document.querySelectorAll('.hover-modal-parent').forEach(function (element) {
        element.addEventListener('mouseover', function () {
            this.querySelector('.hover-modal-content').style.display = 'block';
        });
        element.addEventListener('mouseout', function () {
            this.querySelector('.hover-modal-content').style.display = 'none';
        });
    });
</script>

@endsection
