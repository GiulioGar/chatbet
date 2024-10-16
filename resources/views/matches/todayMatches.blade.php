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
                    @for ($i = 0; $i <= 6; $i++)
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
                                <th>Casa</th>
                                <th>Forma</th>
                                <th>Ospite</th>
                                <th>Forma</th>
                                <th>Quote</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($matches as $match)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($match->match_time)->format('H:i') }}</td>
                                    <td>
                                        <span class="team">{{ $match->homeTeam->name }}</span>
                                    </td>
                                    <td>
                                        <span class="team-form">{{ $match->homeTeam->forma }}</span>
                                    </td>
                                    <td>
                                        <span class="team">{{ $match->awayTeam->name }}</span>
                                    </td>
                                    <td>
                                        <span class="team-form">{{ $match->awayTeam->forma }}</span>
                                    </td>
                                    <td>Quote Placeholder</td>
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
