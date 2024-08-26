<!-- resources/views/admin/update-data.blade.php -->
@extends('layouts.app')

@section('title', 'Aggiornamento Dati')

@section('content')
<div class="container">
    <h1>Aggiorna Dati per Tutti i Campionati</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('admin.update-data.execute') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Aggiorna Tutti i Dati</button>
    </form>
</div>
@endsection
