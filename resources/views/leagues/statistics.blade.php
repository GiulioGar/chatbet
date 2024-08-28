@extends('layouts.app')

@section('title', 'Statistiche della Lega')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 20px;
    }
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
                    <p><strong>Season:</strong> 2024/25</p>
                    <p><strong>Matches:</strong> {{ $playMatches }}/ {{ $totalMatches }} Giocate</p>
                    <p><strong>Progress:</strong> <b>{{ $percMatches }}</b>% completato</p>
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
                <h4>Prossimi 10 Match - {{ $leagueName }}</h4>
                @if($nextMatches->isEmpty())
                    <p>Nessuna partita programmata al momento.</p>
                @else
                    <table class="table table-striped matches-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Orario</th>
                                <th>Squadra Casa</th>
                                <th>Quota Casa</th>
                                <th>Squadra Ospite</th>
                                <th>Quota Ospite</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nextMatches as $match)
                                <tr>
                                    <td>{{ $match->match_date }}</td>
                                    <td>{{ $match->match_time }}</td>
                                    <td>{{ $match->homeTeam->name ?? 'N/A' }}</td>
                                    <td class="text-warning">1.00</td> <!-- Placeholder per quota casa -->
                                    <td>{{ $match->awayTeam->name ?? 'N/A' }}</td>
                                    <td class="text-success">3.00</td> <!-- Placeholder per quota ospite -->
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
        <div class="col-md-12">
            <div class="container-custom">
                <h4>Serie A Table (Italy) - 2024/25</h4>
                <table class="table table-striped table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Team</th>
                            <th>MP</th>
                            <th>W</th>
                            <th>D</th>
                            <th>L</th>
                            <th>GF</th>
                            <th>GA</th>
                            <th>GD</th>
                            <th>Pts</th>
                            <th>Last 5</th>
                            <th>PPG</th>
                            <th>CS</th>
                            <th>BTTS</th>
                            <th>xGF</th>
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
                            <td>3.00</td>
                            <td>100%</td>
                            <td>0%</td>
                            <td>1.37</td>
                        </tr>
                        <!-- Altre righe di squadre -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

@endsection
