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

    // Calcola la classifica per la lega di queste squadre
    $leagueId = $homeTeamData->league_id; // Assumendo che entrambe le squadre siano nella stessa lega
    $leagueName = $this->leagueController->getLeagueNameById($leagueId);

    $teams = Team::where('league_id', $leagueId)->get();

    // Calcola punti e ordina per classifica
// Richiama i punti e ordina per classifica
$teams = $teams->sortByDesc(function ($team) {
    return [$team->points, $team->goal_difference, $team->t_goals_for];
})->values();


    // Trova le posizioni attuali delle due squadre
    $homeTeamPosition = $teams->search(function ($team) use ($homeTeamData) {
        return $team->team_id === $homeTeamData->team_id;
    }) + 1;

    $awayTeamPosition = $teams->search(function ($team) use ($awayTeamData) {
        return $team->team_id === $awayTeamData->team_id;
    }) + 1;

    // Assegna i punti calcolati direttamente ai modelli delle squadre
    $homeTeamData->points = ($homeTeamData->t_wins * 3) + $homeTeamData->t_draws;
    $awayTeamData->points = ($awayTeamData->t_wins * 3) + $awayTeamData->t_draws;

    // Recupera i dettagli della partita
    $match = Matches::where('home_id', $homeTeamData->team_id)
                    ->where('away_id', $awayTeamData->team_id)
                    ->first();

    // Ottieni gli ultimi 5 risultati per ciascuna squadra
    $homeTeamLastFive = $this->getLastFiveMatches($homeTeamData->team_id);
    $awayTeamLastFive = $this->getLastFiveMatches($awayTeamData->team_id);

     // Calcola le probabilità di vittoria, pareggio e sconfitta
     $matchProbabilities = $this->calculateMatchProbabilities($homeTeamData, $awayTeamData);

    // Passa i dati alla vista
    return view('matches.statMatch', [
        'homeTeam' => $homeTeamData,
        'awayTeam' => $awayTeamData,
        'match' => $match,
        'homeTeamPosition' => $homeTeamPosition,
        'awayTeamPosition' => $awayTeamPosition,
        'homeTeamLastFive' => $homeTeamLastFive,
        'awayTeamLastFive' => $awayTeamLastFive,
        'leagueName' => $leagueName, // Passa il nome della lega alla vista
        'teams' => $teams, // Passa la classifica delle squadre alla vista
        'matchProbabilities' => $matchProbabilities, // Passa le probabilità alla vista
    ]);
}


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

    private function calculateMatchProbabilities($homeTeamData, $awayTeamData)
    {
        // Dati delle squadre
        $homeLevel = $homeTeamData->level;
        $awayLevel = $awayTeamData->level;

        $homeForma = $homeTeamData->forma;
        $awayForma = $awayTeamData->forma;

        $homePoints = $homeTeamData->points;
        $awayPoints = $awayTeamData->points;

        $homeGoalDifference = $homeTeamData->goal_difference;
        $awayGoalDifference = $awayTeamData->goal_difference;

        $homePossession = $homeTeamData->t_ball_possession;
        $awayPossession = $awayTeamData->t_ball_possession;

        // Vantaggio del campo
        $homeFieldAdvantage = 1; // 1 per la squadra di casa
        $awayFieldAdvantage = 0; // 0 per la squadra ospite

        // Passo 1: Normalizzazione dei Dati

        // Trova i valori massimi per la normalizzazione
        $maxLevel = max($homeLevel, $awayLevel);
        $maxForma = max($homeForma, $awayForma);
        $maxPoints = max($homePoints, $awayPoints);
        $maxPossession = max($homePossession, $awayPossession);

        // Aggiustamento della differenza reti per evitare valori negativi
        $minGoalDifference = min($homeGoalDifference, $awayGoalDifference);
        $offsetGoalDifference = 0;
        if ($minGoalDifference < 0) {
            $offsetGoalDifference = abs($minGoalDifference);
        }

        $homeGoalDifferenceAdjusted = $homeGoalDifference + $offsetGoalDifference;
        $awayGoalDifferenceAdjusted = $awayGoalDifference + $offsetGoalDifference;

        $maxGoalDifferenceAdjusted = max($homeGoalDifferenceAdjusted, $awayGoalDifferenceAdjusted);

        // Normalizzazione
        $homeLevelNorm = $homeLevel / $maxLevel;
        $awayLevelNorm = $awayLevel / $maxLevel;

        $homeFormaNorm = $homeForma / $maxForma;
        $awayFormaNorm = $awayForma / $maxForma;

        $homePointsNorm = $homePoints / $maxPoints;
        $awayPointsNorm = $awayPoints / $maxPoints;

        // Normalizzazione della differenza reti aggiustata
        if ($maxGoalDifferenceAdjusted > 0) {
            $homeGoalDifferenceNorm = $homeGoalDifferenceAdjusted / $maxGoalDifferenceAdjusted;
            $awayGoalDifferenceNorm = $awayGoalDifferenceAdjusted / $maxGoalDifferenceAdjusted;
        } else {
            $homeGoalDifferenceNorm = 0;
            $awayGoalDifferenceNorm = 0;
        }

        $homePossessionNorm = $homePossession / $maxPossession;
        $awayPossessionNorm = $awayPossession / $maxPossession;

        // Passo 2: Calcolo dei Punteggi Ponderati
        $homeScore = (
            $homeLevelNorm * 0.30 +
            $homeFormaNorm * 0.27 +
            $homePointsNorm * 0.25 +
            $homeFieldAdvantage * 0.07 +
            $homeGoalDifferenceNorm * 0.08 +
            $homePossessionNorm * 0.03
        );

        $awayScore = (
            $awayLevelNorm * 0.30 +
            $awayFormaNorm * 0.27 +
            $awayPointsNorm * 0.25 +
            $awayFieldAdvantage * 0.07 +
            $awayGoalDifferenceNorm * 0.08 +
            $awayPossessionNorm * 0.03
        );

        // Identificazione della squadra più forte e più debole
        if ($homeScore >= $awayScore) {
            $strongerScore = $homeScore;
            $weakerScore = $awayScore;
            $strongerTeam = 'home';
        } else {
            $strongerScore = $awayScore;
            $weakerScore = $homeScore;
            $strongerTeam = 'away';
        }

        // Calcolo dell'indice di disparità
        $scoreDifference = $strongerScore - $weakerScore;
        $scoreSum = $strongerScore + $weakerScore;
        $disparityIndex = $scoreDifference / $scoreSum;

        // Passo 3: Calcolo della Probabilità di Pareggio
        $maxDrawProbability = 0.30; // 30% massima probabilità di pareggio
        $k = 1.5; // Costante per la funzione esponenziale, aumentata per ridurre la dipendenza da disparità
        $drawProbability = $maxDrawProbability * exp(-$k * $disparityIndex);

        // Passo 4: Calcolo delle Probabilità di Vittoria
        $totalWinProbability = 1 - $drawProbability;

        $strongerWinProbability = $totalWinProbability * ($strongerScore / ($strongerScore + $weakerScore));
        $weakerWinProbability = $totalWinProbability * ($weakerScore / ($strongerScore + $weakerScore));

        // Passo 5: Aggiustamento in base all'indice di disparità
        $disparityThreshold = 0.20; // Soglia di disparità

        if ($disparityIndex >= $disparityThreshold) {
            // Ridurre la probabilità della squadra più debole in base alla disparità
            // Più alta è la disparità, maggiore è la riduzione
            $adjustmentFactor = ($disparityIndex - $disparityThreshold) / (1 - $disparityThreshold);
            // Definire un massimo per la squadra più debole che diminuisce con l'aumento della disparità
            $maxWeakerWinProbability = 0.15 * (1 - $adjustmentFactor); // Da 15% a 0%

            if ($weakerWinProbability > $maxWeakerWinProbability) {
                $difference = $weakerWinProbability - $maxWeakerWinProbability;
                $weakerWinProbability = $maxWeakerWinProbability;
                $strongerWinProbability += $difference; // Aumenta la probabilità della squadra più forte
            }
        }

        // Passo 6: Assicurarsi che le probabilità sommino a 1
        $totalProbability = $strongerWinProbability + $drawProbability + $weakerWinProbability;

        // Normalizzazione finale delle probabilità
        if ($strongerTeam === 'home') {
            $homeWinProbability = $strongerWinProbability;
            $awayWinProbability = $weakerWinProbability;
        } else {
            $homeWinProbability = $weakerWinProbability;
            $awayWinProbability = $strongerWinProbability;
        }

        $homeWinProbability /= $totalProbability;
        $drawProbability /= $totalProbability;
        $awayWinProbability /= $totalProbability;

        // Convertire in percentuali
        $homeWinPercentage = round($homeWinProbability * 100, 2);
        $drawPercentage = round($drawProbability * 100, 2);
        $awayWinPercentage = round($awayWinProbability * 100, 2);

        return [
            'homeWin' => $homeWinPercentage,
            'draw' => $drawPercentage,
            'awayWin' => $awayWinPercentage,
        ];
    }





}
