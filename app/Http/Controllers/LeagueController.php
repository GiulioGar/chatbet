<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches; // Modello per accedere ai dati delle partite
use App\Models\Team;    // Modello per accedere ai dati delle squadre
use Illuminate\Support\Facades\Log; // Per il logging
use Carbon\Carbon; // Importa Carbon per la gestione delle date
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

    /**
     * Mostra la pagina delle statistiche per la lega specificata.
     *
     * @param string $leagueSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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
            $playMatches = $totalMatches - $remainingMatches;
            $percMatches = floor(($playMatches / $totalMatches) * 100);

            // Recupera le prossime 10 partite ordinate per data
            $nextMatches = $this->getNextTenMatches($leagueId);

            // Aggiungi le ultime 5 partite per ogni squadra
            foreach ($nextMatches as $match) {
                $match->home_last_five = $this->getLastFiveMatches($match->home_id);
                $match->away_last_five = $this->getLastFiveMatches($match->away_id);
            }

            // Log per debugging
            Log::info("Partite e squadre recuperate per la lega: $leagueSlug", [
                'matches' => $matches->toArray(),
                'team_count' => $teamCount,
                'total_matches' => $totalMatches,
                'remaining_matches' => $remainingMatches,
            ]);

            // Passa i dati alla vista
            return view('leagues.statistics', [
                'leagueName' => $this->formatLeagueName($leagueSlug),
                'matches' => $matches,
                'teams' => $teams,
                'teamCount' => $teamCount,
                'totalMatches' => $totalMatches,       // Passa il numero totale di partite alla vista
                'remainingMatches' => $remainingMatches, // Passa il numero di partite ancora da giocare alla vista
                'playMatches' => $playMatches,         // Partite giocate
                'percMatches' => $percMatches,         // Percentuale delle partite giocate
                'nextMatches' => $nextMatches,         // Prossimi 10 match
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
     * Recupera le prossime 10 partite della lega, ordinate per data e orario.
     * Formatta la data come "Ven 30 Ago" e l'orario come le prime 4 cifre.
     */
    private function getNextTenMatches($leagueId)
    {
        // Imposta la lingua italiana per Carbon
        Carbon::setLocale('it');

        return Matches::with(['homeTeam', 'awayTeam'])
            ->where('league_id', $leagueId)
            ->whereNull('home_score') // Assumendo che le partite future non abbiano un punteggio
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->take(10)
            ->get()
            ->map(function ($match) {
                // Formatta la data in italiano
                $match->formatted_date = Carbon::parse($match->match_date)->translatedFormat('D d M');
                // Formatta l'orario (prendendo solo le prime 5 cifre)
                $match->formatted_time = substr($match->match_time, 0, 5);
                return $match;
            });
    }

    /**
     * Ottieni le ultime 5 partite giocate da una squadra specifica.
     *
     * @param int $teamId
     * @return \Illuminate\Support\Collection
     */
    public function getLastFiveMatches($teamId)
    {
        return Matches::with(['homeTeam', 'awayTeam'])
            ->where(function ($query) use ($teamId) {
                $query->where('home_id', $teamId)
                      ->orWhere('away_id', $teamId);
            })
            ->whereNotNull('home_score') // Considera solo le partite con punteggi definiti
            ->whereNotNull('away_score')
            ->orderBy('match_date', 'desc')
            ->orderBy('match_time', 'desc')
            ->take(5)
            ->get()
            ->map(function ($match) use ($teamId) {
                // Determina il risultato considerando i punteggi
                if ($match->home_id == $teamId) {
                    // Squadra gioca in casa
                    $match->is_home = true;
                    if ($match->home_score > $match->away_score) {
                        $match->result = 'win';
                        $match->resultLogo = '🥳';
                    } elseif ($match->home_score < $match->away_score) {
                        $match->result = 'lose';
                        $match->resultLogo = '🤬';
                    } else {
                        $match->result = 'draw';
                        $match->resultLogo = '🟨';
                    }
                } else {
                    // Squadra gioca fuori casa
                    $match->is_home = false;
                    if ($match->away_score > $match->home_score) {
                        $match->result = 'win';
                        $match->resultLogo = '🥳';
                    } elseif ($match->away_score < $match->home_score) {
                        $match->result = 'lose';
                        $match->resultLogo = '🤬';
                    } else {
                        $match->result = 'draw';
                        $match->resultLogo = '🟨';
                    }
                }
                return $match;
            });
    }



    /**
     * Formatta il nome della lega sostituendo i trattini con spazi e capitalizzando.
     */
    private function formatLeagueName($slug)
    {
        return ucfirst(str_replace('-', ' ', $slug));
    }
}
