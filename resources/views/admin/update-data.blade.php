@extends('layouts.app')

@section('title', 'Aggiornamento Dati')

@section('content')
<div class="container">
    <h1>Aggiorna Dati delle Partite</h1>

    <!-- Messaggio di successo o errore -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form per aggiornare le partite -->
    <form action="{{ route('admin.update-data.execute') }}" method="POST">
        @csrf
        <input type="hidden" name="action" value="updateMatches">
        <button type="submit" class="btn btn-primary">Aggiorna Partite</button>
    </form>

    <!-- Form per aggiornare le statistiche -->
    <form action="{{ route('admin.update-data.execute') }}" method="POST" style="margin-top: 10px;">
        @csrf
        <input type="hidden" name="action" value="updateStatistics">
        <button type="submit" class="btn btn-secondary">Aggiorna Statistiche</button>
    </form>
</div>
@endsection
