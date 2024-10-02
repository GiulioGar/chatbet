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

    // Calcola Clean Sheets totali, casa e fuori casa per il team di casa
    $homeCleanSheetsTotal = Matches::where(function($query) use ($homeTeamData) {
        $query->where('home_id', $homeTeamData->team_id)->where('away_score', 0)
              ->orWhere('away_id', $homeTeamData->team_id)->where('home_score', 0);
    })->count();

$homeCleanSheetsHome = Matches::where('home_id', $homeTeamData->team_id)
      ->where('away_score', 0)
      ->count();

$homeCleanSheetsAway = Matches::where('away_id', $homeTeamData->team_id)
      ->where('home_score', 0)
      ->count();

// Calcola Clean Sheets totali, casa e fuori casa per il team ospite
$awayCleanSheetsTotal = Matches::where(function($query) use ($awayTeamData) {
        $query->where('home_id', $awayTeamData->team_id)->where('away_score', 0)
              ->orWhere('away_id', $awayTeamData->team_id)->where('home_score', 0);
    })->count();

$awayCleanSheetsHome = Matches::where('home_id', $awayTeamData->team_id)
      ->where('away_score', 0)
      ->count();

$awayCleanSheetsAway = Matches::where('away_id', $awayTeamData->team_id)
      ->where('home_score', 0)
      ->count();


 // Calcolo Gol + Over 2.5 per il team di casa (partite generali)
 $homeGolOver25Total = Matches::where(function($query) use ($homeTeamData) {
    $query->where(function($query) use ($homeTeamData) {
          $query->where('home_id', $homeTeamData->team_id)
                ->where('home_score', '>', 0)
                ->where('away_score', '>', 0);
          })
          ->orWhere(function($query) use ($homeTeamData) {
              $query->where('away_id', $homeTeamData->team_id)
                    ->where('home_score', '>', 0)
                    ->where('away_score', '>', 0);
          });
    })
    ->whereRaw('(home_score + away_score) >= 3')
    ->count();

// Calcolo Gol + Over 2.5 per le partite in casa
$homeGolOver25Home = Matches::where('home_id', $homeTeamData->team_id)
->where('home_score', '>', 0)
->where('away_score', '>', 0)
->whereRaw('(home_score + away_score) >= 3')
->count();

// Calcolo Gol + Over 2.5 per le partite fuori casa
$homeGolOver25Away = Matches::where('away_id', $homeTeamData->team_id)
->where('home_score', '>', 0)
->where('away_score', '>', 0)
->whereRaw('(home_score + away_score) >= 3')
->count();

// Calcolo Gol + Over 2.5 per il team ospite (partite generali)
$awayGolOver25Total = Matches::where(function($query) use ($awayTeamData) {
    $query->where(function($query) use ($awayTeamData) {
          $query->where('home_id', $awayTeamData->team_id)
                ->where('home_score', '>', 0)
                ->where('away_score', '>', 0);
          })
          ->orWhere(function($query) use ($awayTeamData) {
              $query->where('away_id', $awayTeamData->team_id)
                    ->where('home_score', '>', 0)
                    ->where('away_score', '>', 0);
          });
    })
    ->whereRaw('(home_score + away_score) >= 3')
    ->count();

// Calcolo Gol + Over 2.5 per le partite in casa del team ospite
$awayGolOver25Home = Matches::where('home_id', $awayTeamData->team_id)
->where('home_score', '>', 0)
->where('away_score', '>', 0)
->whereRaw('(home_score + away_score) >= 3')
->count();

// Calcolo Gol + Over 2.5 per le partite fuori casa del team ospite
$awayGolOver25Away = Matches::where('away_id', $awayTeamData->team_id)
->where('home_score', '>', 0)
->where('away_score', '>', 0)
->whereRaw('(home_score + away_score) >= 3')
->count();


// Calcolo dei corner per Over 6 fino a Over 13
$matches = Matches::where(function($query) use ($homeTeamData, $awayTeamData) {
    $query->where('home_id', $homeTeamData->team_id)
          ->orWhere('away_id', $awayTeamData->team_id);
})->get();

// Inizializza le soglie per Over e i contatori
$thresholds = range(6, 13); // Da Over 6 a Over 13
$overCounters = array_fill_keys($thresholds, 0); // Inizializza contatori a 0
$totalMatches = $matches->count();

foreach ($matches as $match) {
    $totalCorners = $match->corners_home + $match->corners_away;

    // Incrementa i contatori per ogni soglia
    foreach ($thresholds as $threshold) {
        if ($totalCorners > $threshold) {
            $overCounters[$threshold]++;
        }
    }
}

// Calcola le percentuali
$overPercentages = [];
foreach ($overCounters as $threshold => $count) {
    $overPercentages[$threshold] = $totalMatches > 0 ? round(($count / $totalMatches) * 100, 2) : 0;
}



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

        // **Calcola le probabilità di Over/Under e Gol Gol**
        $overUnderProbabilities = $this->calculateOverUnderProbabilities($homeTeamData, $awayTeamData);

            // Calcolo dei corner attesi
        $expectedCorners = $this->calculateExpectedCorners($homeTeamData, $awayTeamData);

         // Calcolo delle percentuali
        $overPercentages = $this->calculateOverPercentages($homeTeamData, $awayTeamData);



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
        'overUnderProbabilities' => $overUnderProbabilities,
        'homeCleanSheetsTotal' => $homeCleanSheetsTotal,
        'homeCleanSheetsHome' => $homeCleanSheetsHome,
        'homeCleanSheetsAway' => $homeCleanSheetsAway,
        'awayCleanSheetsTotal' => $awayCleanSheetsTotal,
        'awayCleanSheetsHome' => $awayCleanSheetsHome,
        'awayCleanSheetsAway' => $awayCleanSheetsAway,
        'homeGolOver25Total' => $homeGolOver25Total,
        'homeGolOver25Home' => $homeGolOver25Home,
        'homeGolOver25Away' => $homeGolOver25Away,
        'awayGolOver25Total' => $awayGolOver25Total,
        'awayGolOver25Home' => $awayGolOver25Home,
        'awayGolOver25Away' => $awayGolOver25Away,
        'expectedCorners' => $expectedCorners,
        'overPercentages' => $overPercentages, // Passa le percentuali alla vista
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
            'level' => 0.67,
            'forma' => 0.20,
            'goal_diff' => 0.05,
            'xG' => 0.6,
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

      /**
     * Calcola le probabilità di Over/Under e Gol Gol.
     *
     * @param object $homeTeamData
     * @param object $awayTeamData
     * @return array
     */
    private function calculateOverUnderProbabilities($homeTeamData, $awayTeamData)
    {
        // Calcolo dei Gol Attesi per ciascuna squadra

        // Evitare divisioni per zero
        $homePlayed = max($homeTeamData->t_played, 1);
        $awayPlayed = max($awayTeamData->t_played, 1);

        // Media gol fatti e subiti per partita
        $homeGoalsForPerMatch = $homeTeamData->t_goals_for / $homePlayed;
        $awayGoalsAgainstPerMatch = $awayTeamData->t_goals_against / $awayPlayed;
        $homeXG = $homeTeamData->xg;

        $awayGoalsForPerMatch = $awayTeamData->t_goals_for / $awayPlayed;
        $homeGoalsAgainstPerMatch = $homeTeamData->t_goals_against / $homePlayed;
        $awayXG = $awayTeamData->xg;

        // Gol Attesi
        $this->homeExpectedGoals = ($homeGoalsForPerMatch + $awayGoalsAgainstPerMatch + $homeXG) / 3;
        $this->awayExpectedGoals = ($awayGoalsForPerMatch + $homeGoalsAgainstPerMatch + $awayXG) / 3;
        $totalExpectedGoals = $this->homeExpectedGoals + $this->awayExpectedGoals;

        // Assegnazione delle probabilità basate sui gol attesi
        $probabilityOver15Goals = $this->getExpectedGoalsProbability($totalExpectedGoals, 'over_1_5');
        $probabilityOver25Goals = $this->getExpectedGoalsProbability($totalExpectedGoals, 'over_2_5');
        $probabilityOver35Goals = $this->getExpectedGoalsProbability($totalExpectedGoals, 'over_3_5');
        $probabilityBothTeamsScore = $this->calculateProbabilityBothTeamsScore();

        // Percentuali storiche
        $avgOver15Historical = $this->getHistoricalPercentage($homeTeamData, $awayTeamData, 'over_1_5');
        $avgOver25Historical = $this->getHistoricalPercentage($homeTeamData, $awayTeamData, 'over_2_5');
        $avgOver35Historical = $this->getHistoricalPercentage($homeTeamData, $awayTeamData, 'over_3_5');
        $avgBothTeamsScoreHistorical = $this->getHistoricalPercentage($homeTeamData, $awayTeamData, 'gg');

        // Combinazione delle probabilità con i pesi
        $weightExpectedGoals = 0.6;
        $weightHistorical = 0.4;

        $finalOver15Probability = ($probabilityOver15Goals * $weightExpectedGoals) + ($avgOver15Historical * $weightHistorical);
        $finalOver25Probability = ($probabilityOver25Goals * $weightExpectedGoals) + ($avgOver25Historical * $weightHistorical);
        $finalOver35Probability = ($probabilityOver35Goals * $weightExpectedGoals) + ($avgOver35Historical * $weightHistorical);
        $finalBothTeamsScoreProbability = ($probabilityBothTeamsScore * $weightExpectedGoals) + ($avgBothTeamsScoreHistorical * $weightHistorical);

        // Arrotondamento delle probabilità
        $probabilities = [
            'over_1_5' => round($finalOver15Probability, 2),
            'over_2_5' => round($finalOver25Probability, 2),
            'over_3_5' => round($finalOver35Probability, 2),
            'both_teams_to_score' => round($finalBothTeamsScoreProbability, 2),
        ];

        return $probabilities;
    }

    private $homeExpectedGoals;
    private $awayExpectedGoals;

    private function getExpectedGoalsProbability($totalExpectedGoals, $type)
    {
        switch ($type) {
            case 'over_1_5':
                if ($totalExpectedGoals >= 2.5) return 90.0;
                if ($totalExpectedGoals >= 2.0) return 85.0;
                if ($totalExpectedGoals >= 1.5) return 80.0;
                return 75.0;
            case 'over_2_5':
                if ($totalExpectedGoals >= 3.5) return 70.0;
                if ($totalExpectedGoals >= 3.0) return 65.0;
                if ($totalExpectedGoals >= 2.5) return 55.0;
                if ($totalExpectedGoals >= 2.0) return 45.0;
                return 35.0;
            case 'over_3_5':
                if ($totalExpectedGoals >= 4.5) return 50.0;
                if ($totalExpectedGoals >= 4.0) return 40.0;
                if ($totalExpectedGoals >= 3.5) return 27.0;
                if ($totalExpectedGoals >= 3.0) return 20.0;
                return 15.0;
            default:
                return 0.0;
        }
    }

    private function calculateProbabilityBothTeamsScore()
    {
        $probHomeScores = (1 - exp(-$this->homeExpectedGoals)) * 100;
        $probAwayScores = (1 - exp(-$this->awayExpectedGoals)) * 100;

        // Utilizziamo il prodotto delle probabilità
        $probabilityBTTS = ($probHomeScores * $probAwayScores) / 100;

        return $probabilityBTTS;
    }

    private function getHistoricalPercentage($homeTeamData, $awayTeamData, $type)
    {
        $homeTotalMatches = max($homeTeamData->t_played, 1);
        $awayTotalMatches = max($awayTeamData->t_played, 1);

        switch ($type) {
            case 'over_1_5':
                $homeStat = $homeTeamData->t_over_1_5_ft;
                $awayStat = $awayTeamData->t_over_1_5_ft;
                break;
            case 'over_2_5':
                $homeStat = $homeTeamData->t_over_2_5_ft;
                $awayStat = $awayTeamData->t_over_2_5_ft;
                break;
            case 'over_3_5':
                $homeStat = $homeTeamData->t_over_3_5_ft;
                $awayStat = $awayTeamData->t_over_3_5_ft;
                break;
            case 'gg':
                $homeStat = $homeTeamData->t_gg_ft;
                $awayStat = $awayTeamData->t_gg_ft;
                break;
            default:
                $homeStat = 0;
                $awayStat = 0;
        }

        $homePercentage = ($homeStat / $homeTotalMatches) * 100;
        $awayPercentage = ($awayStat / $awayTotalMatches) * 100;

        $averagePercentage = ($homePercentage + $awayPercentage) / 2;

        return $averagePercentage;
    }


public function calculateExpectedCorners($homeTeamData, $awayTeamData)
{
    // Recupera i dati necessari dalle squadre
    $homeCornersTotal = $homeTeamData->t_corners;
    $homeCornersHome = $homeTeamData->h_corners;
    $homeCornersAway = $homeTeamData->a_corners;
    $homeShots = $homeTeamData->t_total_shots;
    $homeGamesPlayed = $homeTeamData->t_played;

    $awayCornersTotal = $awayTeamData->t_corners;
    $awayCornersHome = $awayTeamData->h_corners;
    $awayCornersAway = $awayTeamData->a_corners;
    $awayShots = $awayTeamData->t_total_shots;
    $awayGamesPlayed = $awayTeamData->t_played;

    // Pesatura per la squadra di casa
    $homeCornersWeighted = (0.7 * ($homeCornersHome / ($homeGamesPlayed / 2))) + (0.3 * ($homeCornersAway / ($homeGamesPlayed / 2)));

    // Pesatura per la squadra in trasferta
    $awayCornersWeighted = (0.7 * ($awayCornersAway / ($awayGamesPlayed / 2))) + (0.3 * ($awayCornersHome / ($awayGamesPlayed / 2)));

    // Applicazione dell'handicap del 10% per la squadra in trasferta
    $awayCornersWeighted *= 0.9;

    // Calcolo dei corner attesi dai tiri per entrambe le squadre
    $homeCornersFromShots = ($homeShots / $homeGamesPlayed) * ($homeCornersTotal / $homeShots);
    $awayCornersFromShots = ($awayShots / $awayGamesPlayed) * ($awayCornersTotal / $awayShots) * 0.9;

    // Calcolo della media ponderata finale tra corner totali e corner dai tiri
    $expectedHomeCorners = (0.65 * $homeCornersWeighted) + (0.35 * $homeCornersFromShots);
    $expectedAwayCorners = (0.65 * $awayCornersWeighted) + (0.35 * $awayCornersFromShots);

    // Somma dei corner attesi per la partita
    $totalExpectedCorners = $expectedHomeCorners + $expectedAwayCorners;

    return round($totalExpectedCorners, 2); // Risultato arrotondato a 2 decimali
}

public function calculateOverPercentages($teamData, $opponentData)
{
    $overPercentages = [];

    // Definiamo le soglie degli Over corner (da 6 a 13)
    $thresholds = range(6, 13);

    // Funzione per calcolare la percentuale di Over corner
    $calculateOverPercentage = function($team, $threshold) {
        $overMatches = Matches::where(function ($query) use ($team) {
            $query->where('home_id', $team->team_id)
                  ->orWhere('away_id', $team->team_id);
        })
        ->whereRaw('(corners_home + corners_away) > ?', [$threshold])
        ->count();

        $totalMatches = max($team->t_played, 1); // Evita divisioni per 0
        return round(($overMatches / $totalMatches) * 100, 2);
    };

    // Ciclo per calcolare le percentuali per ogni soglia
    foreach ($thresholds as $threshold) {
        $overPercentages[$threshold] = [
            'home' => $calculateOverPercentage($teamData, $threshold),
            'away' => $calculateOverPercentage($opponentData, $threshold)
        ];
    }

    return $overPercentages;
}



}
