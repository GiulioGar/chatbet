@extends('layouts.app')

@section('title', 'Statistiche della Lega')

@section('content')

<link href="{{ asset('css/statistic.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >




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
                                    <td><a href="{{ route('match.statMatch', ['homeTeam' => $match->homeTeam->name, 'awayTeam' => $match->awayTeam->name]) }}" class="btn btn-sm btn-link">Stats</a></td>
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
        <div class="col-md-8">
            <div class="container-custom">
                <h4>Classifica  {{ $leagueName }} - 2024/25</h4>
                <table class="table table-striped table-custom table-classifica">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Squadra</th>
                            <th>Partite</th>
                            <th>V</th>
                            <th>N</th>
                            <th>S</th>
                            <th>GF</th>
                            <th>GS</th>
                            <th>DR</th>
                            <th>PUN</th>
                            <th>ANDAMENTO</th>
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
                    @endphp
                            <tr>
                                <td class="{{ $positionClass }}">{{ $loop->iteration }}</td>
                                <td>{{ $team->name }}</td>
                                <td>{{ $team->t_played }}</td>
                                <td>{{ $team->t_wins }}</td>
                                <td>{{ $team->t_draws }}</td>
                                <td>{{ $team->t_losses }}</td>
                                <td>{{ $team->t_goals_for }}</td>
                                <td>{{ $team->t_goals_against }}</td>
                                <td>{{ $team->goal_difference }}</td>
                                <td><b>{{ $team->points }}</b></td>
                                <td>
                                    @php
                                        $lastFiveResults = $team->matches()
                                            ->whereNotNull('home_score')
                                            ->whereNotNull('away_score')
                                            ->orderBy('match_date', 'desc')
                                            ->take(5)
                                            ->get();
                                    @endphp

                                    @foreach($lastFiveResults as $result)
                                        @if(($result->home_id == $team->team_id && $result->home_score > $result->away_score) ||
                                            ($result->away_id == $team->team_id && $result->away_score > $result->home_score))
                                            <span class="badge badge-success badge-custom">W</span>
                                        @elseif($result->home_score == $result->away_score)
                                            <span class="badge badge-warning badge-custom">D</span>
                                        @else
                                            <span class="badge badge-danger badge-custom">L</span>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
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
