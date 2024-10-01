@extends('layouts.app')

@section('title', 'Statistiche della Partita')

@section('content')

<link href="{{ asset('css/statMatch.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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

        <div class="row">
            <div class="col-md-12">
                <!-- Header -->
                <div class="card-custom">
                    <div class="header">Esito incontro</div>
                    <!-- Squadra e Percentuali -->
                    <div class="row-team">
                        <img src="https://media.api-sports.io/football/teams/{{ $homeTeam->team_id }}.png" alt="{{ $homeTeam->name }}" class="team-logo">
                        <div class="progress-bar-container">
                            <div class="progress-bar">
                                <div class="progress-segment progress-green" style="width: {{ $matchProbabilities['homeWin'] * 100 }}%; left: 0%;">
                                    <span>{{ number_format($matchProbabilities['homeWin'] * 100, 2) }}%</span>
                                </div>
                                <div class="progress-segment progress-yellow" style="width: {{ $matchProbabilities['draw'] * 100 }}%; left: {{ $matchProbabilities['homeWin'] * 100 }}%;">
                                    <span>{{ number_format($matchProbabilities['draw'] * 100, 2) }}%</span>
                                </div>
                                <div class="progress-segment progress-red" style="width: {{ $matchProbabilities['awayWin'] * 100 }}%; left: {{ ($matchProbabilities['homeWin'] + $matchProbabilities['draw']) * 100 }}%;">
                                    <span>{{ number_format($matchProbabilities['awayWin'] * 100, 2) }}%</span>
                                </div>
                            </div>
                        </div>
                        <img src="https://media.api-sports.io/football/teams/{{ $awayTeam->team_id }}.png" alt="{{ $awayTeam->name }}" class="team-logo">
                    </div>

                    <!-- Tabelle Squadre -->
                    <div class="row-team">
                        <!-- Tabella Home Team -->
                        <div class="team-table">
                            <div class="team-header">
                                <img src="https://media.api-sports.io/football/teams/{{ $homeTeam->team_id }}.png" alt="{{ $homeTeam->name }}" class="team-logo">
                                <div>
                                    <h4>{{ $homeTeam->name }}</h4>
                                    <p style="color:#f0eeee">Forma attuale:{{ $homeTeam->fascia }}</p>
                                </div>
                            </div>
                            <table class="team-stats">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Totale</th>
                                        <th>Casa</th>
                                        <th>Ospite</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Giocate</td>
                                        <td>{{ $homeTeam->t_played }}</td>
                                        <td>{{ $homeTeam->h_played }}</td>
                                        <td>{{ $homeTeam->a_played }}</td>
                                    </tr>
                                    <tr>
                                        <td>% Vittoria</td>
                                        <td>{{ $homeTeam->t_wins > 0 ? round(($homeTeam->t_wins / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                                        <td>{{ $homeTeam->h_wins > 0 ? round(($homeTeam->h_wins / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                                        <td>{{ $homeTeam->a_wins > 0 ? round(($homeTeam->a_wins / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>% Pareggio</td>
                                        <td>{{ $homeTeam->t_draws > 0 ? round(($homeTeam->t_draws / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                                        <td>{{ $homeTeam->h_draws > 0 ? round(($homeTeam->h_draws / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                                        <td>{{ $homeTeam->a_draws > 0 ? round(($homeTeam->a_draws / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>% Sconfitta</td>
                                        <td>{{ $homeTeam->t_losses > 0 ? round(($homeTeam->t_losses / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                                        <td>{{ $homeTeam->h_losses > 0 ? round(($homeTeam->h_losses / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                                        <td>{{ $homeTeam->a_losses > 0 ? round(($homeTeam->a_losses / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Punti</td>
                                        <td>{{ $homePointsGeneral }}</td>
                                        <td>{{ $homePointsHome }} ({{ $homePointsHomePercentage }}%)</td>
                                        <td>{{ $homePointsAway }} ({{ $homePointsAwayPercentage }}%)</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <!-- Tabella Away Team -->
                        <div class="team-table">
                            <div class="team-header">
                                <img src="https://media.api-sports.io/football/teams/{{ $awayTeam->team_id }}.png" alt="{{ $awayTeam->name }}" class="team-logo">
                                <div>
                                    <h4>{{ $awayTeam->name }}</h4>
                                    <p style="color:#f0eeee">Forma attuale:{{ $awayTeam->fascia }}</p>
                                </div>
                            </div>
                            <table class="team-stats">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Totale</th>
                                        <th>Casa</th>
                                        <th>Ospite</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Giocate</td>
                                        <td>{{ $awayTeam->t_played }}</td>
                                        <td>{{ $awayTeam->h_played }}</td>
                                        <td>{{ $awayTeam->a_played }}</td>
                                    </tr>
                                    <tr>
                                        <td>% Vittoria</td>
                                        <td>{{ round(($awayTeam->t_wins / $awayTeam->t_played) * 100, 2) }}%</td>
                                        <td>{{ round(($awayTeam->h_wins / $awayTeam->h_played) * 100, 2) }}%</td>
                                        <td>{{ round(($awayTeam->a_wins / $awayTeam->a_played) * 100, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>% Pareggio</td>
                                        <td>{{ round(($awayTeam->t_draws / $awayTeam->t_played) * 100, 2) }}%</td>
                                        <td>{{ round(($awayTeam->h_draws / $awayTeam->h_played) * 100, 2) }}%</td>
                                        <td>{{ round(($awayTeam->a_draws / $awayTeam->a_played) * 100, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>% Sconfitta</td>
                                        <td>{{ round(($awayTeam->t_losses / $awayTeam->t_played) * 100, 2) }}%</td>
                                        <td>{{ round(($awayTeam->h_losses / $awayTeam->h_played) * 100, 2) }}%</td>
                                        <td>{{ round(($awayTeam->a_losses / $awayTeam->a_played) * 100, 2) }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Punti</td>
                                        <td>{{ $awayPointsGeneral }}</td>
                                        <td>{{ $awayPointsHome }} ({{ $awayPointsHomePercentage }}%)</td>
                                        <td>{{ $awayPointsAway }} ({{ $awayPointsAwayPercentage }}%)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



<div class="row">
<div class="col-md-12">
    <div class="card-custom">
        <div class="header">Gol & Over</div>

        <div class="row-team">
            <!-- Statistiche Box -->
            <div class="row g-3">
                <!-- Statistica 1 -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-box text-center p-4">
                        <div class="stat-number">{{ $overUnderProbabilities['over_1_5'] }}%</div>
                        <div class="stat-description">Over 1.5</div>
                        <div class="footer-bar footer-primary" style="width: {{ $overUnderProbabilities['over_1_5'] }}%;"></div>
                    </div>
                </div>

                <!-- Statistica 2 -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-box text-center p-4">
                        <div class="stat-number">{{ $overUnderProbabilities['over_2_5'] }}%</div>
                        <div class="stat-description">Over 2.5</div>
                        <div class="footer-bar footer-warning" style="width: {{ $overUnderProbabilities['over_2_5'] }}%;"></div>
                    </div>
                </div>

                <!-- Statistica 3 -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-box text-center p-4">
                        <div class="stat-number">{{ $overUnderProbabilities['over_3_5'] }}%</div>
                        <div class="stat-description">Over 3.5</div>
                        <div class="footer-bar footer-danger" style="width: {{ $overUnderProbabilities['over_3_5'] }}%;"></div>
                    </div>
                </div>

                <!-- Statistica 4 -->
                <div class="col-md-3 col-sm-6">
                    <div class="stat-box text-center p-4">
                        <div class="stat-number">{{ $overUnderProbabilities['both_teams_to_score'] }}%</div>
                        <div class="stat-description">Gol Gol</div>
                        <div class="footer-bar footer-success" style="width: {{ $overUnderProbabilities['both_teams_to_score'] }}%;"></div>
                    </div>
                </div>
            </div>
        </div>



<div class="row-team">
    <!-- Tabella Home Team -->
    <div class="team-table">
        <div class="team-header">
            <img src="https://media.api-sports.io/football/teams/{{ $homeTeam->team_id }}.png" alt="{{ $homeTeam->name }}" class="team-logo">
            <div>
                <h4>{{ $homeTeam->name }}</h4>
                <p style="color:#f0eeee">Difesa:{{ $homeTeam->fascia }}</p>
            </div>
        </div>
        <table class="team-stats">
            <thead>
                <tr>
                    <th></th>
                    <th>Totale</th>
                    <th>Casa</th>
                    <th>Ospite</th>
                </tr>
            </thead>
            <tbody>
                <!-- Gol Fatti -->
                <tr>
                    <td>Gol Fatti</td>
                    <td>{{ $homeTeam->t_goals_for }}</td>
                    <td>{{ $homeTeam->h_goals_for }}</td>
                    <td>{{ $homeTeam->a_goals_for }}</td>
                </tr>
                <!-- Gol Subiti -->
                <tr>
                    <td>Gol Subiti</td>
                    <td>{{ $homeTeam->t_goals_against }}</td>
                    <td>{{ $homeTeam->h_goals_against }}</td>
                    <td>{{ $homeTeam->a_goals_against }}</td>
                </tr>
                <!-- Media Gol Fatti a partita -->
                <tr>
                    <td>Media Gol</td>
                    <td>{{ $homeTeam->t_played > 0 ? round($homeTeam->t_goals_for / $homeTeam->t_played, 2) : 0 }}</td>
                    <td>{{ $homeTeam->h_played > 0 ? round($homeTeam->h_goals_for / $homeTeam->h_played, 2) : 0 }}</td>
                    <td>{{ $homeTeam->a_played > 0 ? round($homeTeam->a_goals_for / $homeTeam->a_played, 2) : 0 }}</td>
                </tr>
                <!-- Over 1.5 -->
                <tr>
                    <td>Over 1.5</td>
                    <td>{{ $homeTeam->t_played > 0 ? round(($homeTeam->t_over_1_5_ft / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->h_played > 0 ? round(($homeTeam->h_over_1_5_ft / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->a_played > 0 ? round(($homeTeam->a_over_1_5_ft / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>
                <!-- Over 2.5 -->
                <tr>
                    <td>Over 2.5</td>
                    <td>{{ $homeTeam->t_played > 0 ? round(($homeTeam->t_over_2_5_ft / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->h_played > 0 ? round(($homeTeam->h_over_2_5_ft / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->a_played > 0 ? round(($homeTeam->a_over_2_5_ft / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>
                <!-- Over 3.5 -->
                <tr>
                    <td>Over 3.5</td>
                    <td>{{ $homeTeam->t_played > 0 ? round(($homeTeam->t_over_3_5_ft / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->h_played > 0 ? round(($homeTeam->h_over_3_5_ft / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->a_played > 0 ? round(($homeTeam->a_over_3_5_ft / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>
                <!-- Gol Gol (Entrambe le squadre segnano) -->
                <tr>
                    <td>Gol Gol</td>
                    <td>{{ $homeTeam->t_played > 0 ? round(($homeTeam->t_gg_ft / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->h_played > 0 ? round(($homeTeam->h_gg_ft / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->a_played > 0 ? round(($homeTeam->a_gg_ft / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>

                        <!-- Gol + Over 2.5 -->
                    <tr>
                        <td>Gol + Over 2.5</td>
                        <td>{{ $homeTeam->t_played > 0 ? round(($homeGolOver25Total / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                        <td>{{ $homeTeam->h_played > 0 ? round(($homeGolOver25Home / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                        <td>{{ $homeTeam->a_played > 0 ? round(($homeGolOver25Away / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                    </tr>

                <tr>
                    <td>Clean Sheets</td>
                    <td>{{ $homeTeam->t_played > 0 ? round(($homeCleanSheetsTotal / $homeTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->h_played > 0 ? round(($homeCleanSheetsHome / $homeTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $homeTeam->a_played > 0 ? round(($homeCleanSheetsAway / $homeTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>

                <tr>
                    <td>Expected Gol</td>
                    <td colspan="3">{{ $homeTeam->xg }}</td>
                    </tr>

            </tbody>
        </table>


    </div>

    <!-- Tabella Away Team -->
    <div class="team-table">
        <div class="team-header">
            <img src="https://media.api-sports.io/football/teams/{{ $awayTeam->team_id }}.png" alt="{{ $awayTeam->name }}" class="team-logo">
            <div>
                <h4>{{ $awayTeam->name }}</h4>
                <p style="color:#f0eeee">Forma attuale:{{ $awayTeam->fascia }}</p>
            </div>
        </div>
        <table class="team-stats">
            <thead>
                <tr>
                    <th></th>
                    <th>Totale</th>
                    <th>Casa</th>
                    <th>Ospite</th>
                </tr>
            </thead>
            <tbody>
                <!-- Gol Fatti -->
                <tr>
                    <td>Gol Fatti</td>
                    <td>{{ $awayTeam->t_goals_for }}</td>
                    <td>{{ $awayTeam->h_goals_for }}</td>
                    <td>{{ $awayTeam->a_goals_for }}</td>
                </tr>
                <!-- Gol Subiti -->
                <tr>
                    <td>Gol Subiti</td>
                    <td>{{ $awayTeam->t_goals_against }}</td>
                    <td>{{ $awayTeam->h_goals_against }}</td>
                    <td>{{ $awayTeam->a_goals_against }}</td>
                </tr>
                <!-- Media Gol Fatti a partita -->
                <tr>
                    <td>Media Gol</td>
                    <td>{{ $awayTeam->t_played > 0 ? round($awayTeam->t_goals_for / $awayTeam->t_played, 2) : 0 }}</td>
                    <td>{{ $awayTeam->h_played > 0 ? round($awayTeam->h_goals_for / $awayTeam->h_played, 2) : 0 }}</td>
                    <td>{{ $awayTeam->a_played > 0 ? round($awayTeam->a_goals_for / $awayTeam->a_played, 2) : 0 }}</td>
                </tr>
                <!-- Over 1.5 -->
                <tr>
                    <td>Over 1.5</td>
                    <td>{{ $awayTeam->t_played > 0 ? round(($awayTeam->t_over_1_5_ft / $awayTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->h_played > 0 ? round(($awayTeam->h_over_1_5_ft / $awayTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->a_played > 0 ? round(($awayTeam->a_over_1_5_ft / $awayTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>
                <!-- Over 2.5 -->
                <tr>
                    <td>Over 2.5</td>
                    <td>{{ $awayTeam->t_played > 0 ? round(($awayTeam->t_over_2_5_ft / $awayTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->h_played > 0 ? round(($awayTeam->h_over_2_5_ft / $awayTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->a_played > 0 ? round(($awayTeam->a_over_2_5_ft / $awayTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>
                <!-- Over 3.5 -->
                <tr>
                    <td>Over 3.5</td>
                    <td>{{ $awayTeam->t_played > 0 ? round(($awayTeam->t_over_3_5_ft / $awayTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->h_played > 0 ? round(($awayTeam->h_over_3_5_ft / $awayTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->a_played > 0 ? round(($awayTeam->a_over_3_5_ft / $awayTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>
                <!-- Gol Gol (Entrambe le squadre segnano) -->
                <tr>
                    <td>Gol Gol</td>
                    <td>{{ $awayTeam->t_played > 0 ? round(($awayTeam->t_gg_ft / $awayTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->h_played > 0 ? round(($awayTeam->h_gg_ft / $awayTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->a_played > 0 ? round(($awayTeam->a_gg_ft / $awayTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>

                        <!-- Gol + Over 2.5 -->
                        <tr>
                            <td>Gol + Over 2.5</td>
                            <td>{{ $awayTeam->t_played > 0 ? round(($awayGolOver25Total / $awayTeam->t_played) * 100, 2) : 0 }}%</td>
                            <td>{{ $awayTeam->h_played > 0 ? round(($awayGolOver25Home / $awayTeam->h_played) * 100, 2) : 0 }}%</td>
                            <td>{{ $awayTeam->a_played > 0 ? round(($awayGolOver25Away / $awayTeam->a_played) * 100, 2) : 0 }}%</td>
                        </tr>

                <tr>
                    <td>Clean Sheets</td>
                    <td>{{ $awayTeam->t_played > 0 ? round(($awayCleanSheetsTotal / $awayTeam->t_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->h_played > 0 ? round(($awayCleanSheetsHome / $awayTeam->h_played) * 100, 2) : 0 }}%</td>
                    <td>{{ $awayTeam->a_played > 0 ? round(($awayCleanSheetsAway / $awayTeam->a_played) * 100, 2) : 0 }}%</td>
                </tr>

                <tr>
                <td>Expected Gol</td>
                <td colspan="3">{{ $awayTeam->xg }}</td>
                </tr>

            </tbody>
        </table>
    </div>
</div>



</div>

  </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="custom-card-light p-3">
                <div class="custom-header-light d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('images/corner.png') }}" alt="Corner icon" class="mr-3" style="width: 40px;">
                        <div>
                            <h5 class="mb-1">Corners/Partita</h5>
                            <p class="small mb-0 custom-highlight">Linea Corner:  {{ $expectedCorners }}</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="custom-match-box mx-2 d-flex align-items-center">
                            {{ $homeTeam->t_played > 0 ? round(($homeTeam->t_corners / $homeTeam->t_played), 2) : 0 }}
                            <span>/partita</span>
                            <img src="https://media.api-sports.io/football/teams/{{ $homeTeam->team_id }}.png" alt="{{ $homeTeam->name }}" class="ml-2" style="width: 30px;">
                        </div>
                        <div class="custom-match-box mx-2 d-flex align-items-center">
                            {{ $homeTeam->t_played > 0 ? round(($awayTeam->t_corners / $awayTeam->t_played), 2) : 0 }}
                            <span>/partita</span>
                            <img src="https://media.api-sports.io/football/teams/{{ $awayTeam->team_id }}.png" alt="{{ $homeTeam->name }}" class="ml-2" style="width: 30px;">
                        </div>
                    </div>
                </div>

                <!-- Sezione Corners Totali -->
                <div class="custom-corner-data-section">
                    <ul class="nav nav-tabs mb-3" id="cornerTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active custom-tab-link" id="total-tab" data-toggle="tab" href="#corner-totali" role="tab" aria-controls="corner-totali" aria-selected="true">Corner Totali</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="cornerTabContent">
                        <div class="tab-pane fade show active" id="corner-totali" role="tabpanel" aria-labelledby="total-tab">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center custom-table">
                                    <thead>
                                        <tr>
                                            <th>Calci d'angolo</th>
                                            <th>{{ $homeTeam->name }}</th>
                                            <th>{{ $awayTeam->name }}</th>
                                            <th>Media</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Over 6</td>
                                            <td><i class="fa fa-lock"></i></td>
                                            <td><i class="fa fa-lock"></i></td>
                                            <td><i class="fa fa-lock"></i></td>
                                        </tr>
                                        <tr>
                                            <td>Over 7</td>
                                            <td><i class="fa fa-lock"></i></td>
                                            <td><i class="fa fa-lock"></i></td>
                                            <td><i class="fa fa-lock"></i></td>
                                        </tr>
                                        <!-- Aggiungi altre righe come necessario -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="primo-secondo" role="tabpanel" aria-labelledby="first-second-tab">
                            <!-- Contenuto per la sezione Primo/Secondo Tempo -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




 <!-- Fine lato desto -->
</div>

        <div class="col-md-4">
            <!-- Sezione laterale per statistiche aggiuntive o classifiche -->
            <div class="card mb-4">
                <div class="card-header"><span style="text-transform: uppercase">{{ $leagueName }}</span> - Classifica</div>
                <div class="card-body">
                    <!-- Contenuti della classifica -->
                    <p>

                        <table style="font-size: 11px" class="table table-striped table-custom table-classifica">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Squadra</th>
                                    <th>Partite</th>
                                    <th>GF</th>
                                    <th>GS</th>
                                    <th>PUN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $index => $team)
                                @php
                                $positionClass = '';
                                if ($loop->iteration == 1) {
                                    $positionClass = 'position-gold';
                                } elseif ($loop->iteration >= 2 && $loop->iteration <= 4) {
                                    $positionClass = 'position-silver';
                                } elseif ($loop->iteration >= 5 && $loop->iteration <= 6) {
                                    $positionClass = 'position-bronze';
                                } elseif ($loop->iteration >= 18 && $loop->iteration <= 20) {
                                    $positionClass = 'position-red';
                                }
                            // Definisce una classe condizionale per cambiare lo sfondo
                                $highlightClass = '';
                                if ($team->name === $homeTeam->name || $team->name === $awayTeam->name) {
                                    $highlightClass = 'highlight-team'; // Aggiunge la classe se il nome della squadra corrisponde
                                }
                            @endphp
                                    <tr>
                                        <td class="{{ $positionClass }}">{{ $loop->iteration }}</td>
                                        <td class="{{ $highlightClass }}">{{ $team->name }}</td>
                                        <td class="{{ $highlightClass }}">{{ $team->t_played }}</td>
                                        <td class="{{ $highlightClass }}">{{ $team->t_goals_for }}</td>
                                        <td class="{{ $highlightClass }}">{{ $team->t_goals_against }}</td>
                                        <td class="{{ $highlightClass }}"><b>{{ $team->points }}</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </p>
                </div>
            </div>
        </div>
    </div>

</div>



@endsection
