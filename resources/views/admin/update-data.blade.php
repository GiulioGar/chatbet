@extends('layouts.app')

@section('title', 'Aggiornamento Dati')

@section('content')
<div class="container">
    <h3 class="my-4">Aggiornamento Dati delle Partite</h3>

    <div class="row">
        <!-- Colonna dei bottoni -->
        <div class="col-md-4">
            <!-- Card per l'aggiornamento delle partite -->
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">

                </div>
                <div class="card-body">
                    <p>Aggiorna i dati delle partite attuali con le ultime informazioni dalle API.</p>
                    <form action="{{ route('admin.update-data.execute') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="updateMatches">
                        <button type="submit" class="btn btn-primary btn-block">Aggiorna</button>
                    </form>
                </div>
            </div>

            <!-- Card per l'aggiornamento delle statistiche -->
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">

                </div>
                <div class="card-body">
                    <p>Aggiorna le statistiche dettagliate delle partite già giocate, come tiri in porta, cartellini, etc.</p>
                    <form action="{{ route('admin.update-data.execute') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="updateStatistics">
                        <button type="submit" class="btn btn-secondary btn-block">Aggiorna</button>
                    </form>
                </div>
            </div>

            <!-- Card per l'aggiornamento delle statistiche delle squadre -->
            <div class="card mb-3">
                <div class="card-header bg-success text-white">

                </div>
                <div class="card-body">
                    <p>Aggiorna le statistiche delle squadre e dati vari senza interrogare API.</p>
                    <form action="{{ route('admin.update-teams.execute') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">Aggiorna </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Colonna per il div dei risultati -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Risultati Aggiornamenti</h5>
                </div>
                <div class="card-body">
                    <p id="resultArea">Qui verranno visualizzati i risultati degli aggiornamenti.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
