<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches; // Modello per accedere ai dati delle partite
use Illuminate\Support\Facades\Log; // Per il logging
use Exception;

class LeagueController extends Controller
{
    public function show($leagueSlug)
    {
        // Mappa degli slug delle leghe agli ID delle leghe
        $leagueMapping = [
            'serie-a' => 135,
            'premier-league' => 39,
            'la-liga' => 140,
            'bundesliga' => 78,
            'ligue-1' => 61,
            // Aggiungi altri campionati secondo necessità
        ];

        // Controlla se lo slug fornito esiste nel mapping
        if (!array_key_exists($leagueSlug, $leagueMapping)) {
            abort(404, 'Lega non trovata'); // Mostra un errore 404 se la lega non esiste
        }

        // Ottieni l'ID della lega dal mapping
        $leagueId = $leagueMapping[$leagueSlug];

        try {
            // Recupera le partite dal database usando l'ID della lega con eager loading
            $matches = Matches::with(['homeTeam', 'awayTeam'])->where('league_id', $leagueId)->get();

            // Log per verificare i dati recuperati
            Log::info('Partite recuperate per la lega: ' . $leagueSlug, ['matches' => $matches->toArray()]);

            // Controlla se ci sono partite recuperate
            if ($matches->isEmpty()) {
                return view('leagues.statistics', [
                    'leagueName' => ucfirst(str_replace('-', ' ', $leagueSlug)), // Trasforma 'serie-a' in 'Serie A'
                    'matches' => $matches,
                    'message' => 'Non ci sono partite disponibili per questa lega al momento.'
                ]);
            }

            // Debug per verificare le relazioni
            foreach ($matches as $match) {
                Log::info('Match ID: ' . $match->id . ', Home Team ID: ' . $match->home_id . ', Home Team Name: ' . ($match->homeTeam?->name ?? 'N/A') . ', Away Team ID: ' . $match->away_id . ', Away Team Name: ' . ($match->awayTeam?->name ?? 'N/A'));
            }

            // Passa i dati alla vista
            return view('leagues.statistics', [
                'leagueName' => ucfirst(str_replace('-', ' ', $leagueSlug)), // Trasforma 'serie-a' in 'Serie A'
                'matches' => $matches
            ]);

        } catch (Exception $e) {
            // Logga l'errore per il debugging
            Log::error('Errore durante il recupero delle partite per la lega: ' . $leagueSlug, ['exception' => $e]);

            // Mostra un messaggio di errore all'utente
            return back()->with('error', 'Si è verificato un errore durante il caricamento delle partite. Riprova più tardi.');
        }
    }
}
