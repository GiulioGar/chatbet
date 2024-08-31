@extends('layouts.app')

@section('title', 'Statistiche della Partita')

@section('content')
<div class="container mt-4">
    <h2>Statistiche della Partita: {{ $homeTeam->name }} vs {{ $awayTeam->name }}</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Dettagli Generali</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Data</th>
                    <td>{{ $match->match_date }}</td>
                </tr>
                <tr>
                    <th>Orario</th>
                    <td>{{ $match->match_time }}</td>
                </tr>
                <tr>
                    <th>Stadio</th>
                    <td>{{ $match->stadium ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Arbitro</th>
                    <td>{{ $match->referee ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="col-md-6">
            <h4>Statistiche</h4>
            <table class="table table-bordered">
                <tr>
                    <th>Gol {{ $homeTeam->name }}</th>
                    <td>{{ $match->home_score }}</td>
                </tr>
                <tr>
                    <th>Gol {{ $awayTeam->name }}</th>
                    <td>{{ $match->away_score }}</td>
                </tr>
                <tr>
                    <th>Tiri in Porta {{ $homeTeam->name }}</th>
                    <td>{{ $match->sog_home }}</td>
                </tr>
                <tr>
                    <th>Tiri in Porta {{ $awayTeam->name }}</th>
                    <td>{{ $match->sog_away }}</td>
                </tr>
                <!-- Aggiungi altre statistiche come necessario -->
            </table>
        </div>
    </div>
</div>
@endsection
