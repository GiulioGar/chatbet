@extends('layouts.app')

@section('content')
<link href="{{ asset('css/todayMatches.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">


<div class="container main-content">
    <div class="row tableMatches">
        <div class="col-md-12">

            <!-- Menu per le date -->
            <div class="date-menu">
                <ul class="date-selector">
                    @for ($i = 0; $i <= 8; $i++)
                        @php
                            $date = \Carbon\Carbon::today()->addDays($i);
                        @endphp
                        <li class="{{ $selectedDate->isSameDay($date) ? 'active' : '' }}">
                            <a href="{{ route('match.todayMatches', $date->format('Y-m-d')) }}">
                                {{ $date->translatedFormat('D d M') }} <!-- Mostra la data come "Gio 16 OTT" -->
                            </a>
                        </li>
                    @endfor
                </ul>
            </div>

            <!-- Contenitore per le partite -->
            <div class="matches-container">
                @if($matches->isEmpty())
                    <p class="no-matches-message">Nessuna partita in programma</p>
                @else
                    <table class="matches-table">
                        <thead>
                            <tr>
                                <th>Ora</th>
                                <th>Campionato</th>
                                <th colspan="4">Partita</th>
                                <th>1</th>
                                <th>X</th>
                                <th>2</th>
                                <th>OV 1.5</th>
                                <th>OV 2.5</th>
                                <th>OV 3.5</th>
                                <th>G/G</th>
                                <th>Corner</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matches as $match)
                            <tr>
                                <!-- Orario della partita -->
                                <td>{{ \Carbon\Carbon::parse($match->match_time)->format('H:i') }}</td>

                                <!-- Lega della partita -->
                                <td><span class="league"> {{ config('leagues.by_id.' . $match->homeTeam->league_id, 'Lega Sconosciuta') }} </span></td>

                                <!-- Logo squadra di casa -->
                                <td><img src="https://media.api-sports.io/football/teams/{{ $match->homeTeam->team_id }}.png" alt="" class="team-logo"></td>

                                <!-- Nome squadra di casa con fascia -->
                                <td><span class="team">{{ $match->homeTeam->name }}</span> (<span class="team">{{ $match->homeTeam->fascia }}</span>)</td>

                                <!-- Nome squadra ospite con fascia -->
                                <td><span class="team">{{ $match->awayTeam->name }} (<span class="team">{{ $match->awayTeam->fascia }}</span>)</td>

                                <!-- Logo squadra ospite -->
                                <td><img src="https://media.api-sports.io/football/teams/{{ $match->awayTeam->team_id }}.png" alt="" class="team-logo"></td>


                                <!-- Visualizziamo le probabilità per il match -->
                                <td><span>{{ number_format($matchesProbabilities[$match->id]['homeWin'] * 100, 0) }}%</span></td>
                                <td><span>{{ number_format($matchesProbabilities[$match->id]['draw'] * 100, 0) }}%</span></td>
                                <td><span>{{ number_format($matchesProbabilities[$match->id]['awayWin'] * 100, 0) }}%</span></td>

                                <!-- Visualizziamo le probabilità Over -->
                                <td><span>{{ number_format($overUnderProbabilities[$match->id]['over_1_5'], 0) }}%</span></td>
                                <td><span>{{ number_format($overUnderProbabilities[$match->id]['over_2_5'], 0) }}%</span></td>
                                <td><span>{{ number_format($overUnderProbabilities[$match->id]['over_3_5'], 0) }}%</span></td>
                                <td><span>{{ number_format($overUnderProbabilities[$match->id]['both_teams_to_score'], 0) }}%</span></td>


                                <!-- Visualizziamo i corner attesi -->
                                 <td> @if(isset($expectedCornersData[$match->id])) <span>{{ number_format($expectedCornersData[$match->id], 2) }}</span> @else <span>N/A</span> @endif </td>

                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection
