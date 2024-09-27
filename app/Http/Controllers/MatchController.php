<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matches;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\LeagueController;

class MatchController extends Controller
{
    protected $leagueController;

    public function __construct()
    {
        $this->leagueController = new LeagueController();
    }

    public function showStatistics($homeTeam, $awayTeam)
{
    // Recupera le squadre dal database
    $homeTeamData = Team::where('name', $homeTeam)->first();
    $awayTeamData = Team::where('name', $awayTeam)->first();

    if (!$homeTeamData || !$awayTeamData) {
        Log::error("Una o entrambe le squadre non sono state trovate: $homeTeam, $awayTeam");
        return back()->with('error', 'Squadre non trovate. Riprova con nomi validi.');
    }

    // Calcola le posizioni in classifica
    $leagueId = $homeTeamData->league_id;
    $leagueName = $this->leagueController->getLeagueNameById($leagueId);
    $teams = Team::where('league_id', $leagueId)->get();

    $teams = $teams->sortByDesc(function ($team) {
        return [$team->points, $team->goal_difference, $team->t_goals_for];
    })->values();

    $homeTeamPosition = $teams->search(function ($team) use ($homeTeamData) {
        return $team->team_id === $homeTeamData->team_id;
    }) + 1;

    $awayTeamPosition = $teams->search(function ($team) use ($awayTeamData) {
        return $team->team_id === $awayTeamData->team_id;
    }) + 1;

    // Calcola le statistiche per la colonna Generale
    $homeWinPercentage = ($homeTeamData->t_played > 0) ? round(($homeTeamData->t_wins / $homeTeamData->t_played) * 100, 2) : 0;
    $homeDrawPercentage = ($homeTeamData->t_played > 0) ? round(($homeTeamData->t_draws / $homeTeamData->t_played) * 100, 2) : 0;
    $homeLossPercentage = ($homeTeamData->t_played > 0) ? round(($homeTeamData->t_losses / $homeTeamData->t_played) * 100, 2) : 0;

    $awayWinPercentage = ($awayTeamData->t_played > 0) ? round(($awayTeamData->t_wins / $awayTeamData->t_played) * 100, 2) : 0;
    $awayDrawPercentage = ($awayTeamData->t_played > 0) ? round(($awayTeamData->t_draws / $awayTeamData->t_played) * 100, 2) : 0;
    $awayLossPercentage = ($awayTeamData->t_played > 0) ? round(($awayTeamData->t_losses / $awayTeamData->t_played) * 100, 2) : 0;

    // Calcola le statistiche per la colonna Casa
    $homeHomeWinPercentage = ($homeTeamData->h_played > 0) ? round(($homeTeamData->h_wins / $homeTeamData->h_played) * 100, 2) : 0;
    $homeHomeDrawPercentage = ($homeTeamData->h_played > 0) ? round(($homeTeamData->h_draws / $homeTeamData->h_played) * 100, 2) : 0;
    $homeHomeLossPercentage = ($homeTeamData->h_played > 0) ? round(($homeTeamData->h_losses / $homeTeamData->h_played) * 100, 2) : 0;

    $awayHomeWinPercentage = ($awayTeamData->h_played > 0) ? round(($awayTeamData->h_wins / $awayTeamData->h_played) * 100, 2) : 0;
    $awayHomeDrawPercentage = ($awayTeamData->h_played > 0) ? round(($awayTeamData->h_draws / $awayTeamData->h_played) * 100, 2) : 0;
    $awayHomeLossPercentage = ($awayTeamData->h_played > 0) ? round(($awayTeamData->h_losses / $awayTeamData->h_played) * 100, 2) : 0;

    // Calcola le statistiche per la colonna Ospite
    $homeAwayWinPercentage = ($homeTeamData->a_played > 0) ? round(($homeTeamData->a_wins / $homeTeamData->a_played) * 100, 2) : 0;
    $homeAwayDrawPercentage = ($homeTeamData->a_played > 0) ? round(($homeTeamData->a_draws / $homeTeamData->a_played) * 100, 2) : 0;
    $homeAwayLossPercentage = ($homeTeamData->a_played > 0) ? round(($homeTeamData->a_losses / $homeTeamData->a_played) * 100, 2) : 0;

    $awayAwayWinPercentage = ($awayTeamData->a_played > 0) ? round(($awayTeamData->a_wins / $awayTeamData->a_played) * 100, 2) : 0;
    $awayAwayDrawPercentage = ($awayTeamData->a_played > 0) ? round(($awayTeamData->a_draws / $awayTeamData->a_played) * 100, 2) : 0;
    $awayAwayLossPercentage = ($awayTeamData->a_played > 0) ? round(($awayTeamData->a_losses / $awayTeamData->a_played) * 100, 2) : 0;

    // Calcola i punteggi delle squadre
    $teamScores = $this->calculateTeamScores($homeTeamData, $awayTeamData);


// Calcolo dei punti generali, in casa e fuori casa
$homePointsGeneral = $homeTeamData->points;
$homePointsHome = ($homeTeamData->h_wins * 3) + $homeTeamData->h_draws;
$homePointsAway = ($homeTeamData->a_wins * 3) + $homeTeamData->a_draws;

$awayPointsGeneral = $awayTeamData->points;
$awayPointsHome = ($awayTeamData->h_wins * 3) + $awayTeamData->h_draws;
$awayPointsAway = ($awayTeamData->a_wins * 3) + $awayTeamData->a_draws;

$homePointsHomePercentage = $homePointsGeneral > 0 ? round(($homePointsHome / $homePointsGeneral) * 100, 2) : 0;
$homePointsAwayPercentage = $homePointsGeneral > 0 ? round(($homePointsAway / $homePointsGeneral) * 100, 2) : 0;

$awayPointsHomePercentage = $awayPointsGeneral > 0 ? round(($awayPointsHome / $awayPointsGeneral) * 100, 2) : 0;
$awayPointsAwayPercentage = $awayPointsGeneral > 0 ? round(($awayPointsAway / $awayPointsGeneral) * 100, 2) : 0;


    // Calcola le probabilità di vittoria, pareggio e sconfitta
    try {
        $matchProbabilities = $this->calculateMatchProbabilities($teamScores['homeTeamScore'], $teamScores['awayTeamScore']);
    } catch (\InvalidArgumentException $e) {
        Log::error("Errore nel calcolo delle probabilità: " . $e->getMessage());
        return back()->with('error', 'Errore nel calcolo delle probabilità. Riprova più tardi.');
    }

    // Recupera i dettagli della partita
    $match = Matches::where('home_id', $homeTeamData->team_id)
                    ->where('away_id', $awayTeamData->team_id)
                    ->first();

    // Ottieni gli ultimi 5 risultati per ciascuna squadra
    $homeTeamLastFive = $this->getLastFiveMatches($homeTeamData->team_id);
    $awayTeamLastFive = $this->getLastFiveMatches($awayTeamData->team_id);

    // Passa i dati alla vista
    return view('matches.statMatch', [
        'homeTeam' => $homeTeamData,
        'awayTeam' => $awayTeamData,
        'match' => $match,
        'homeTeamPosition' => $homeTeamPosition,
        'awayTeamPosition' => $awayTeamPosition,
        'homeTeamLastFive' => $homeTeamLastFive,
        'awayTeamLastFive' => $awayTeamLastFive,
        'leagueName' => $leagueName,
        'teams' => $teams,
        'teamScores' => $teamScores,
        'matchProbabilities' => $matchProbabilities,
        'homePointsGeneral' => $homePointsGeneral,
        'homePointsHome' => $homePointsHome,
        'homePointsAway' => $homePointsAway,
        'homePointsHomePercentage' => $homePointsHomePercentage,
        'homePointsAwayPercentage' => $homePointsAwayPercentage,
        'awayPointsGeneral' => $awayPointsGeneral,
        'awayPointsHome' => $awayPointsHome,
        'awayPointsAway' => $awayPointsAway,
        'awayPointsHomePercentage' => $awayPointsHomePercentage,
        'awayPointsAwayPercentage' => $awayPointsAwayPercentage,
    ]);

}

    /**
     * Calcola i punteggi delle squadre basati su diversi fattori.
     *
     * @param object $homeTeamData
     * @param object $awayTeamData
     * @return array
     */
    private function calculateTeamScores($homeTeamData, $awayTeamData)
    {
        // Pesi aggiornati
        $weights = [
            'level' => 0.80,
            'forma' => 0.10,
            'goal_diff' => 0.05,
            'xG' => 0.03,
            'tiri_in_porta' => 0.01,
            'possesso_palla' => 0.01,
        ];

        // Calcolo della differenza di livello
        $levelDifference = $homeTeamData->level - $awayTeamData->level;

        // Funzione interna per calcolare il punteggio di una squadra
        $calculateScore = function ($teamData, $isHome, $applyHandicap = false) use ($weights, $levelDifference) {
            $score = (
                $teamData->level * $weights['level'] +
                $teamData->forma * $weights['forma'] +
                $teamData->goal_difference * $weights['goal_diff'] +
                $teamData->xg * $weights['xG'] +
                $teamData->t_shots_on_goal * $weights['tiri_in_porta'] +
                $teamData->t_ball_possession * $weights['possesso_palla']
            );

            // Aggiunta del vantaggio casa
            if ($isHome) {
                $score *= 1.1;
            }

            // Applicazione dell'handicap dinamico per la squadra più debole
            if ($applyHandicap) {
                $handicapFactor = pow(0.85, $levelDifference / 10);
                $score *= $handicapFactor;
            }

            return $score;
        };

        // Calcola i punteggi per le squadre
        $homeTeamScore = $calculateScore($homeTeamData, true);
        $awayTeamScore = $calculateScore($awayTeamData, false, true);

        return [
            'homeTeamScore' => $homeTeamScore,
            'awayTeamScore' => $awayTeamScore,
        ];
    }

    /**
     * Calcola le probabilità di vittoria, pareggio e sconfitta.
     *
     * @param float $homeTeamScore
     * @param float $awayTeamScore
     * @param float $alpha_base (default: 0.30)
     * @return array
     * @throws \InvalidArgumentException
     */
    private function calculateMatchProbabilities($homeTeamScore, $awayTeamScore, $alpha_base = 0.30)
    {
        // Verifica che i punteggi siano numeri positivi
        if (!is_numeric($homeTeamScore) || !is_numeric($awayTeamScore) || !is_numeric($alpha_base)) {
            throw new \InvalidArgumentException('Tutti i parametri devono essere numeri.');
        }

        if ($homeTeamScore <= 0 || $awayTeamScore <= 0) {
            throw new \InvalidArgumentException('I punteggi di forza devono essere numeri positivi.');
        }

        // Calcolo delle ponderazioni esponenziali
        $ponderazioneA = pow($homeTeamScore, 2);
        $ponderazioneB = pow($awayTeamScore, 2);

        // Calcolo della differenza normalizzata
        $differenza = ($homeTeamScore - $awayTeamScore) / ($homeTeamScore + $awayTeamScore);

        // Calcolo della probabilità dinamica del pareggio
        $probabilitaX = $alpha_base * (1 - $differenza);

        // Assicurarsi che la probabilità del pareggio sia compresa tra 0 e 1
        $probabilitaX = max(0, min(1, $probabilitaX));

        // Calcolo delle probabilità corrette per vittoria A e vittoria B
        $probabilitaA = ($ponderazioneA / ($ponderazioneA + $ponderazioneB)) * (1 - $probabilitaX);
        $probabilitaB = ($ponderazioneB / ($ponderazioneA + $ponderazioneB)) * (1 - $probabilitaX);

        // Assicurarsi che le probabilità siano comprese tra 0 e 1
        $probabilitaA = max(0, min(1, $probabilitaA));
        $probabilitaB = max(0, min(1, $probabilitaB));

        // Arrotondamento delle probabilità a 4 cifre decimali
        $probabilitaA = round($probabilitaA, 4);
        $probabilitaX = round($probabilitaX, 4);
        $probabilitaB = round($probabilitaB, 4);

        // Restituzione dei risultati in un array associativo con chiavi descrittive
        return [
            'homeWin' => $probabilitaA, // Vittoria della squadra di casa (Squadra A)
            'draw'    => $probabilitaX, // Pareggio
            'awayWin' => $probabilitaB  // Vittoria della squadra ospite (Squadra B)
        ];
    }

    /**
     * Ottiene gli ultimi 5 match di una squadra.
     *
     * @param int $teamId
     * @return \Illuminate\Support\Collection
     */
    private function getLastFiveMatches($teamId)
    {
        return Matches::where(function ($query) use ($teamId) {
                    $query->where('home_id', $teamId)
                          ->orWhere('away_id', $teamId);
                })
                ->whereNotNull('home_score')
                ->whereNotNull('away_score')
                ->orderBy('match_date', 'desc')
                ->take(5)
                ->get();
    }
}
