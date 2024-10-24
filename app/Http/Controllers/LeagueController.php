<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches; // Modello per accedere ai dati delle partite
use App\Models\Team;    // Modello per accedere ai dati delle squadre
use Illuminate\Support\Facades\Log; // Per il logging
use Carbon\Carbon; // Importa Carbon per la gestione delle date
use Exception;
use App\Services\TeamStatisticsService; // Servizio per aggiornare le statistiche delle squadre

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

    public function getLeagueNameById($leagueId)
    {
        // Cerca l'ID della lega nella mappa e restituisce il nome corrispondente
        $leagueName = array_search($leagueId, $this->leagueMapping);
        if ($leagueName !== false) {
            return ucfirst(str_replace('-', ' ', $leagueName)); // Formatta il nome della lega
        }

        return null; // Restituisce null se l'ID della lega non è trovato
    }

    /**
     * Mostra la pagina delle statistiche per la lega specificata.
     *
     * @param string $leagueSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($leagueSlug)
    {
        Log::info("Show method called for leagueSlug: $leagueSlug");

        try {
            // Richiama la logica centralizzata per ottenere i dati
            $data = $this->prepareLeagueData($leagueSlug);

            // Passa i dati alla vista
            return view('leagues.statistics', $data);
        } catch (Exception $e) {
            Log::error("Errore durante il recupero delle partite per la lega: $leagueSlug", [
                'exception' => $e->getMessage()
            ]);

            return back()->with('error', 'Si è verificato un errore durante il caricamento delle partite. Riprova più tardi.');
        }
    }

    /**
     * Mostra la pagina delle statistiche delle partite.
     *
     * @param string $leagueSlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showStatMatch($leagueSlug)
    {
        Log::info("ShowStatMatch method called for leagueSlug: $leagueSlug");

        try {
            // Richiama la logica centralizzata per ottenere i dati
            $data = $this->prepareLeagueData($leagueSlug);

            // Passa i dati alla vista statMatch
            return view('leagues.statMatch', $data);
        } catch (Exception $e) {
            Log::error("Errore durante il recupero delle partite per la lega: $leagueSlug", [
                'exception' => $e->getMessage()
            ]);

            return back()->with('error', 'Si è verificato un errore durante il caricamento delle partite. Riprova più tardi.');
        }
    }

    /**
     * Centralizza la logica per preparare i dati di una lega.
     *
     * @param string $leagueSlug
     * @return array
     */
    private function prepareLeagueData($leagueSlug)
    {
        // Ottieni l'ID della lega dallo slug
        $leagueId = $this->getLeagueIdFromSlug($leagueSlug);
        Log::info("Mapped leagueSlug to leagueId: $leagueId");

        // Aggiorna le statistiche delle squadre prima di procedere
        $teamStatsService = new TeamStatisticsService();
        $teamStatsService->updateTeamStatistics();

        // Recupera le partite per la lega specifica
        $matches = $this->getMatchesByLeagueId($leagueId) ?? collect();
        $teams = $this->getTeamsByLeagueId($leagueId) ?? collect(); // Recupera le squadre
        $teamCount = $teams->count();

// Richiama i punti e ordina le squadre
$teams = $teams->sortByDesc(function ($team) {
    return [$team->points, $team->goal_difference, $team->t_goals_for];
});

        // Calcola le statistiche generali
        $totalMatches = $matches->count();
        $remainingMatches = $matches->whereNull('home_score')->count();
        $playMatches = $totalMatches - $remainingMatches;
        $percMatches = $totalMatches > 0 ? floor(($playMatches / $totalMatches) * 100) : 0;

        // Recupera le prossime 10 partite ordinate per data
        $nextMatches = $this->getNextTenMatches($leagueId) ?? collect();

        // Aggiungi le ultime 5 partite per ogni squadra
        foreach ($nextMatches as $match) {
            // Usa collect() per assicurarsi che non sia mai null
            $match->home_last_five = $this->getLastFiveMatches($match->home_id) ?: collect();
            $match->away_last_five = $this->getLastFiveMatches($match->away_id) ?: collect();
        }

        return [
            'leagueName' => $this->formatLeagueName($leagueSlug),
            'matches' => $matches,
            'teams' => $teams,  // Assicurati che $teams venga passato qui
            'teamCount' => $teamCount,
            'totalMatches' => $totalMatches,
            'remainingMatches' => $remainingMatches,
            'playMatches' => $playMatches,
            'percMatches' => $percMatches,
            'nextMatches' => $nextMatches,
        ];
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
     * Recupera tutte le squadre basate sull'ID della lega.
     */
    private function getTeamsByLeagueId($leagueId)
    {
        return Team::where('league_id', $leagueId)->get();
    }

    /**
     * Recupera le prossime 10 partite della lega, ordinate per data e orario.
     * Formatta la data come "Ven 30 Ago" e l'orario come le prime 4 cifre.
     */
    private function getNextTenMatches($leagueId)
    {
        Carbon::setLocale('it');

        return Matches::with(['homeTeam', 'awayTeam'])
            ->where('league_id', $leagueId)
            ->whereNull('home_score') // Assumendo che le partite future non abbiano un punteggio
            ->orderBy('match_date')
            ->orderBy('match_time')
            ->take(10)
            ->get()
            ->map(function ($match) {
                $match->formatted_date = Carbon::parse($match->match_date)->translatedFormat('D d M');
                $match->formatted_time = substr($match->match_time, 0, 5);
                return $match;
            });
    }

    /**
     * Ottieni le ultime 5 partite giocate da una squadra specifica.
     */
    public function getLastFiveMatches($teamId)
    {
        return Matches::with(['homeTeam', 'awayTeam'])
            ->where(function ($query) use ($teamId) {
                $query->where('home_id', $teamId)
                      ->orWhere('away_id', $teamId);
            })
            ->whereNotNull('home_score')
            ->whereNotNull('away_score')
            ->orderBy('match_date', 'desc')
            ->orderBy('match_time', 'desc')
            ->take(5)
            ->get()
            ->map(function ($match) use ($teamId) {
                if ($match->home_id == $teamId) {
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
