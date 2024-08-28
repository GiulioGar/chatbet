<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches; // Modello per accedere ai dati delle partite
use App\Models\Team;    // Modello per accedere ai dati delle squadre
use Illuminate\Support\Facades\Log; // Per il logging
use Exception;

class LeagueController extends Controller
{
    // Mappa degli slug delle leghe agli ID delle leghe
    private $leagueMapping = [
        'serie-a' => 135,
        'premier-league' => 39,
        'la-liga' => 140,
        'bundesliga' => 78,
        'ligue-1' => 61,
        // Aggiungi altri campionati secondo necessità
    ];

    public function show($leagueSlug)
    {
        try {
            // Ottieni l'ID della lega dallo slug
            $leagueId = $this->getLeagueIdFromSlug($leagueSlug);

            // Recupera le partite per la lega specifica
            $matches = $this->getMatchesByLeagueId($leagueId);

            // Aggiorna e ottieni le statistiche delle squadre
            $teams = $this->updateAndGetTeamsStats($leagueId);

            // Conta il numero di squadre
            $teamCount = $teams->count();

            // Calcolo delle statistiche delle partite
            $totalMatches = $matches->count(); // Numero totale di partite giocate e in programma
            $remainingMatches = $matches->whereNull('home_score')->count(); // Partite senza risultato indicano quelle da giocare
            $playMatches = $totalMatches - $remainingMatches; // Calcola il numero di partite giocate
            $percMatches = ($totalMatches > 0) ? floor(($playMatches / $totalMatches) * 100) : 0; // Calcola la percentuale delle partite giocate

            // Recupera le prossime 10 partite ordinate per data e orario
            $nextMatches = $this->getNextTenMatches($leagueId);

            // Log per debugging
            Log::info("Partite e squadre recuperate per la lega: $leagueSlug", [
                'matches' => $matches->toArray(),
                'team_count' => $teamCount,
                'total_matches' => $totalMatches,
                'remaining_matches' => $remainingMatches,
                'play_matches' => $playMatches,
                'perc_matches' => $percMatches,
                'next_matches' => $nextMatches->toArray(),
            ]);

            // Passa i dati alla vista
            return view('leagues.statistics', [
                'leagueName' => $this->formatLeagueName($leagueSlug),
                'matches' => $matches,
                'teams' => $teams,
                'teamCount' => $teamCount,
                'totalMatches' => $totalMatches,       // Passa il numero totale di partite alla vista
                'remainingMatches' => $remainingMatches, // Passa il numero di partite ancora da giocare alla vista
                'playMatches' => $playMatches, // Passa il numero di partite giocate alla vista
                'percMatches' => $percMatches, // Passa la percentuale delle partite giocate alla vista
                'nextMatches' => $nextMatches, // Passa le prossime 10 partite alla vista
            ]);
        } catch (Exception $e) {
            // Logga l'errore per il debugging
            Log::error("Errore durante il recupero delle partite per la lega: $leagueSlug", [
                'exception' => $e->getMessage()
            ]);

            // Mostra un messaggio di errore all'utente
            return back()->with('error', 'Si è verificato un errore durante il caricamento delle partite. Riprova più tardi.');
        }
    }

    /**
     * Ottieni l'ID della lega a partire dallo slug.
     * Controlla se lo slug esiste nel mapping, altrimenti restituisce un errore 404.
     */
    private function getLeagueIdFromSlug($slug)
    {
        if (!array_key_exists($slug, $this->leagueMapping)) {
            abort(404, 'Lega non trovata'); // Slug non trovato
        }

        return $this->leagueMapping[$slug]; // Restituisce l'ID della lega
    }

    /**
     * Recupera tutte le partite basate sull'ID della lega con eager loading per le relazioni.
     */
    private function getMatchesByLeagueId($leagueId)
    {
        return Matches::with(['homeTeam', 'awayTeam'])->where('league_id', $leagueId)->get();
    }

    /**
     * Aggiorna il numero di partite giocate per ogni squadra e restituisce l'elenco aggiornato delle squadre.
     */
    private function updateAndGetTeamsStats($leagueId)
    {
        $teams = Team::where('league_id', $leagueId)->get();

        foreach ($teams as $team) {
            // Conta le partite giocate come squadra di casa o ospite
            $matchesPlayed = Matches::where('home_id', $team->team_id)
                ->orWhere('away_id', $team->team_id)
                ->count();

            // Aggiorna il campo matches_played
            $team->matches_played = $matchesPlayed;
            $team->save();
        }

        return $teams; // Restituisce l'elenco aggiornato delle squadre
    }

    /**
     * Formatta il nome della lega sostituendo i trattini con spazi e capitalizzando.
     */
    private function formatLeagueName($slug)
    {
        return ucfirst(str_replace('-', ' ', $slug));
    }

    /**
     * Recupera le prossime 10 partite della lega, ordinate per data e orario.
     */
    private function getNextTenMatches($leagueId)
    {
        return Matches::with(['homeTeam', 'awayTeam'])
            ->where('league_id', $leagueId)
            ->whereNull('home_score') // Assumendo che le partite future non abbiano un punteggio
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->take(10)
            ->get();
    }
}
