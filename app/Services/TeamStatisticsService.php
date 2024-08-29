<?php

namespace App\Services;

use App\Models\Matches;
use App\Models\Team;
use Illuminate\Support\Facades\Log;

class TeamStatisticsService
{
    public function updateTeamStatistics()
{
    $teams = Team::all();

    foreach ($teams as $team) {
        $teamStats = [
            't_played' => 0,
            't_wins' => 0,
            't_draws' => 0,
            't_losses' => 0,
            't_goals_for' => 0,
            't_goals_against' => 0,
            'h_wins' => 0,
            'h_draws' => 0,
            'h_losses' => 0,
            'a_wins' => 0,
            'a_draws' => 0,
            'a_losses' => 0,
        ];

        $matches = Matches::where('home_id', $team->team_id)
            ->orWhere('away_id', $team->team_id)
            ->get();

        foreach ($matches as $match) {
            // Verifica se i punteggi sono definiti, quindi considera solo i match effettivamente disputati
            if (is_null($match->home_score) || is_null($match->away_score)) {
                continue;
            }

            $teamStats['t_played']++;
            $isHome = $match->home_id == $team->team_id;
            $goalsFor = $isHome ? $match->home_score : $match->away_score;
            $goalsAgainst = $isHome ? $match->away_score : $match->home_score;

            $teamStats['t_goals_for'] += $goalsFor;
            $teamStats['t_goals_against'] += $goalsAgainst;

            if ($goalsFor > $goalsAgainst) {
                $teamStats['t_wins']++;
                $isHome ? $teamStats['h_wins']++ : $teamStats['a_wins']++;
            } elseif ($goalsFor < $goalsAgainst) {
                $teamStats['t_losses']++;
                $isHome ? $teamStats['h_losses']++ : $teamStats['a_losses']++;
            } else {
                $teamStats['t_draws']++;
                $isHome ? $teamStats['h_draws']++ : $teamStats['a_draws']++;
            }
        }

        $team->update($teamStats);
        Log::info("Statistiche aggiornate per la squadra: {$team->name}", $teamStats);
    }
}

}
