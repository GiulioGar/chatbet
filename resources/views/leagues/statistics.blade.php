@extends('layouts.app')

@section('title', 'Statistiche della Lega')

@section('content')
<div class="container">
    <h1>Statistiche {{ $leagueName }}</h1>

    @if($matches->isEmpty())
        <p>Nessuna partita disponibile.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Squadra Casa</th>
                    <th>Squadra Ospite</th>
                    <th>Risultato</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matches as $match)
                    <tr>
                        <td>{{ $match->match_date }}</td>
                        <td>{{ $match->homeTeam?->name ?? 'Squadra sconosciuta' }}</td>
                        <td>{{ $match->awayTeam?->name ?? 'Squadra sconosciuta' }}</td>
                        <td>{{ $match->home_score }} - {{ $match->away_score }}</td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    @endif
</div>
@endsection
