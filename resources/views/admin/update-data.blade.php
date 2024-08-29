@extends('layouts.app')

@section('title', 'Aggiornamento Dati')

@section('content')
<div class="container">
    <h1 class="my-4">Aggiornamento Dati delle Partite</h1>

    <!-- Card per l'aggiornamento delle partite -->
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5>Aggiorna Partite</h5>
        </div>
        <div class="card-body">
            <p>Aggiorna i dati delle partite attuali con le ultime informazioni dalle API.</p>
            <form action="{{ route('admin.update-data.execute') }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="updateMatches">
                <button type="submit" class="btn btn-primary btn-block">Aggiorna Partite</button>
            </form>
        </div>
    </div>

    <!-- Card per l'aggiornamento delle statistiche -->
    <div class="card mb-3">
        <div class="card-header bg-secondary text-white">
            <h5>Aggiorna Statistiche Partite</h5>
        </div>
        <div class="card-body">
            <p>Aggiorna le statistiche dettagliate delle partite già giocate, come tiri in porta, cartellini, etc.</p>
            <form action="{{ route('admin.update-data.execute') }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="updateStatistics">
                <button type="submit" class="btn btn-secondary btn-block">Aggiorna Statistiche</button>
            </form>
        </div>
    </div>

    <!-- Card per l'aggiornamento delle statistiche delle squadre -->
    <div class="card mb-3">
        <div class="card-header bg-success text-white">
            <h5>Aggiorna Statistiche Squadre</h5>
        </div>
        <div class="card-body">
            <p>Aggiorna le statistiche delle squadre basate sulle partite più recenti giocate.</p>
            <form action="{{ route('admin.update-teams.execute') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-block">Aggiorna Statistiche Squadre</button>
            </form>
        </div>
    </div>
</div>
@endsection
