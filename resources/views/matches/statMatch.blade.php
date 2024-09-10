@extends('layouts.app')

@section('title', 'Statistiche della Partita')

@section('content')

<link href="{{ asset('css/statMatch.css') }}" rel="stylesheet">

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


   <!-- Header -->
   <div class="card-custom">
    <div class="header">Statistiche partita</div>

    <!-- Squadra e Percentuali -->
    <div class="row-team">
      <img src="https://media.api-sports.io/football/teams/{{ $homeTeam->team_id}}.png" alt="{{ $homeTeam->name }}" class="team-logo">
      <div class="progress-bar-container">
        <div class="progress-bar">
          <div class="progress-green"></div>
          <div class="progress-yellow"></div>
          <div class="progress-red"></div>
        </div>
      </div>
      <img src="https://media.api-sports.io/football/teams/{{ $awayTeam->team_id}}.png" alt="{{ $awayTeam->name }}" class="team-logo">
    </div>

    <!-- Statistiche Box -->
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="stat-box">
          <div class="stat-number">100%</div>
          <div class="stat-description">Più di 1.5</div>
          <div class="footer-green"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-box">
          <div class="stat-number">50%</div>
          <div class="stat-description">Più di 2.5</div>
          <div class="footer-yellow"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-box">
          <div class="stat-number">20%</div>
          <div class="stat-description">Più di 3.5</div>
          <div class="footer-red"></div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-4">
        <div class="stat-box">
          <div class="stat-number">40%</div>
          <div class="stat-description">BTTS</div>
          <div class="footer-red"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-box">
          <div class="stat-number">10%</div>
          <div class="stat-description">Clean Sheets (Southampton)</div>
          <div class="footer-yellow"></div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="stat-box">
          <div class="stat-number">50%</div>
          <div class="stat-description">Clean Sheets (Brentford)</div>
          <div class="footer-red"></div>
        </div>
      </div>
    </div>
  </div>


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
