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
    $teams = $teams->map(function ($team) {
        $team->points = ($team->t_wins * 3) + $team->t_draws;
        $team->goal_difference = $team->t_goals_for - $team->t_goals_against;
        return $team;
    })->sortByDesc(function ($team) {
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


}
