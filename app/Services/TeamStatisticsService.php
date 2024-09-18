<?php

namespace App\Services;

use App\Models\Matches;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class TeamStatisticsService
{
    public function updateTeamStatistics()
    {
        $teams = Team::where('league_id', '>', 0)->get();

        foreach ($teams as $team) {
            $teamStats = [
                't_played' => 0, 't_wins' => 0, 't_draws' => 0, 't_losses' => 0,
                't_goals_for' => 0, 't_goals_against' => 0,
                't_shots_on_goal' => 0, 't_shots_off_goal' => 0, 't_total_shots' => 0,
                't_saves' => 0, 't_fouls' => 0, 't_corners' => 0,
                't_yellow_cards' => 0, 't_red_cards' => 0, 't_ball_possession' => 0,
                'h_played' => 0, 'a_played' => 0, 'h_wins' => 0, 'a_wins' => 0,
                'h_draws' => 0, 'a_draws' => 0, 'h_losses' => 0, 'a_losses' => 0,
                'h_goals_for' => 0, 'a_goals_for' => 0, 'h_goals_against' => 0, 'a_goals_against' => 0,
                'h_shots_on_goal' => 0, 'a_shots_on_goal' => 0,
                'h_shots_off_goal' => 0, 'a_shots_off_goal' => 0,
                'h_total_shots' => 0, 'a_total_shots' => 0,
                'h_saves' => 0, 'a_saves' => 0, 'h_fouls' => 0, 'a_fouls' => 0,
                'h_corners' => 0, 'a_corners' => 0, 'h_yellow_cards' => 0, 'a_yellow_cards' => 0,
                'h_red_cards' => 0, 'a_red_cards' => 0, 'h_ball_possession' => 0, 'a_ball_possession' => 0,
                't_over_0_5_ht' => 0, 't_over_1_5_ht' => 0, 't_over_2_5_ht' => 0, 't_over_3_5_ht' => 0, 't_gg_ht' => 0,
                't_over_0_5_ft' => 0, 't_over_1_5_ft' => 0, 't_over_2_5_ft' => 0, 't_over_3_5_ft' => 0, 't_gg_ft' => 0,
                'points' => 0, // Nuovo campo per i punti
                'goal_difference' => 0, // Nuovo campo per la differenza reti
                'xg' => 0, // Nuovo campo per Expected Goals
                'prevented' => 0 // Nuovo campo per Goals Prevented
            ];

            $matches = Matches::where(function ($query) use ($team) {
                    $query->where('home_id', $team->team_id)
                          ->orWhere('away_id', $team->team_id);
                })
                ->whereNotNull('home_score')
                ->whereNotNull('away_score')
                ->where('league_id', '>', 0)
                ->get();

            // Variabili per xG e goals prevented
            $homeXgTotal = 0;
            $awayXgTotal = 0;
            $homePreventedTotal = 0;
            $awayPreventedTotal = 0;
            $homeMatchesCount = 0;
            $awayMatchesCount = 0;

            foreach ($matches as $match) {
                $isHome = $match->home_id == $team->team_id;
                $goalsFor = $isHome ? $match->home_score : $match->away_score;
                $goalsAgainst = $isHome ? $match->away_score : $match->home_score;

                // Incrementa statistiche base
                $teamStats['t_played']++;
                $isHome ? $teamStats['h_played']++ : $teamStats['a_played']++;

                // Incrementa i gol
                $teamStats['t_goals_for'] += $goalsFor;
                $teamStats['t_goals_against'] += $goalsAgainst;
                $isHome ? $teamStats['h_goals_for'] += $goalsFor : $teamStats['a_goals_for'] += $goalsFor;
                $isHome ? $teamStats['h_goals_against'] += $goalsAgainst : $teamStats['a_goals_against'] += $goalsAgainst;

                // Calcolo Expected Goals e Goals Prevented
                if ($isHome && !is_null($match->expected_goalsH)) {
                    $homeXgTotal += $match->expected_goalsH;
                    $homePreventedTotal += $match->goals_preventedH;
                    $homeMatchesCount++;
                } elseif (!$isHome && !is_null($match->expected_goalsA)) {
                    $awayXgTotal += $match->expected_goalsA;
                    $awayPreventedTotal += $match->goals_preventedA;
                    $awayMatchesCount++;
                }

                // Incrementa le altre statistiche (tiri, parate, falli, ecc.)
                $shotsOnGoal = $isHome ? $match->sog_home : $match->sog_away;
                if (is_numeric($shotsOnGoal)) {
                    $teamStats['t_shots_on_goal'] += $shotsOnGoal;
                    $isHome ? $teamStats['h_shots_on_goal'] += $shotsOnGoal : $teamStats['a_shots_on_goal'] += $shotsOnGoal;
                }

                $shotsOffGoal = $isHome ? $match->sof_home : $match->sof_away;
                if (is_numeric($shotsOffGoal)) {
                    $teamStats['t_shots_off_goal'] += $shotsOffGoal;
                    $isHome ? $teamStats['h_shots_off_goal'] += $shotsOffGoal : $teamStats['a_shots_off_goal'] += $shotsOffGoal;
                }

                $totalShots = $isHome ? $match->tsh_home : $match->tsh_away;
                if (is_numeric($totalShots)) {
                    $teamStats['t_total_shots'] += $totalShots;
                    $isHome ? $teamStats['h_total_shots'] += $totalShots : $teamStats['a_total_shots'] += $totalShots;
                }

                // Incrementa parate
                $saves = $isHome ? $match->saves_home : $match->saves_away;
                if (is_numeric($saves)) {
                    $teamStats['t_saves'] += $saves;
                    $isHome ? $teamStats['h_saves'] += $saves : $teamStats['a_saves'] += $saves;
                }

                // Incrementa falli
                $fouls = $isHome ? $match->fouls_home : $match->fouls_away;
                if (is_numeric($fouls)) {
                    $teamStats['t_fouls'] += $fouls;
                    $isHome ? $teamStats['h_fouls'] += $fouls : $teamStats['a_fouls'] += $fouls;
                }

                // Incrementa corner
                $corners = $isHome ? $match->corners_home : $match->corners_away;
                if (is_numeric($corners)) {
                    $teamStats['t_corners'] += $corners;
                    $isHome ? $teamStats['h_corners'] += $corners : $teamStats['a_corners'] += $corners;
                }

                // Incrementa cartellini gialli e rossi
                $yellowCards = $isHome ? $match->yc_home : $match->yc_away;
                if (is_numeric($yellowCards)) {
                    $teamStats['t_yellow_cards'] += $yellowCards;
                    $isHome ? $teamStats['h_yellow_cards'] += $yellowCards : $teamStats['a_yellow_cards'] += $yellowCards;
                }

                $redCards = $isHome ? $match->rc_home : $match->rc_away;
                if (is_numeric($redCards)) {
                    $teamStats['t_red_cards'] += $redCards;
                    $isHome ? $teamStats['h_red_cards'] += $redCards : $teamStats['a_red_cards'] += $redCards;
                }

                // Incrementa possesso palla
                $ballPossession = $isHome ? $match->possession_home : $match->possession_away;
                $ballPossession = str_replace('%', '', $ballPossession); // Rimuovi il simbolo di percentuale
                if (is_numeric($ballPossession)) {
                    $teamStats['t_ball_possession'] += $ballPossession;
                    $isHome ? $teamStats['h_ball_possession'] += $ballPossession : $teamStats['a_ball_possession'] += $ballPossession;
                }

                // Aggiorna vittorie, pareggi e sconfitte
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

                // Calcolo Over e Goal Goal per HT e FT
                $htGoals = (int) $match->home_ht + (int) $match->away_ht;
                $ftGoals = (int) $match->home_ft + (int) $match->away_ft;

                if ($htGoals > 0) $teamStats['t_over_0_5_ht']++;
                if ($htGoals > 1) $teamStats['t_over_1_5_ht']++;
                if ($htGoals > 2) $teamStats['t_over_2_5_ht']++;
                if ($htGoals > 3) $teamStats['t_over_3_5_ht']++;
                if ($match->home_ht > 0 && $match->away_ht > 0) $teamStats['t_gg_ht']++;

                if ($ftGoals > 0) $teamStats['t_over_0_5_ft']++;
                if ($ftGoals > 1) $teamStats['t_over_1_5_ft']++;
                if ($ftGoals > 2) $teamStats['t_over_2_5_ft']++;
                if ($ftGoals > 3) $teamStats['t_over_3_5_ft']++;
                if ($match->home_ft > 0 && $match->away_ft > 0) $teamStats['t_gg_ft']++;
            }

            // Calcolo della media del possesso palla
            if ($teamStats['h_played'] > 0) {
                $teamStats['h_ball_possession'] = $teamStats['h_ball_possession'] / $teamStats['h_played'];
            }

            if ($teamStats['a_played'] > 0) {
                $teamStats['a_ball_possession'] = $teamStats['a_ball_possession'] / $teamStats['a_played'];
            }

            if ($teamStats['t_played'] > 0) {
                $teamStats['t_ball_possession'] = $teamStats['t_ball_possession'] / $teamStats['t_played'];
            }

            // Calcolo dei punti e della differenza reti
            $teamStats['points'] = ($teamStats['t_wins'] * 3) + $teamStats['t_draws'];
            $teamStats['goal_difference'] = $teamStats['t_goals_for'] - $teamStats['t_goals_against'];

            // Calcolo della media di Expected Goals (xG)
            $totalXgMatches = $homeMatchesCount + $awayMatchesCount;
            $xg = ($totalXgMatches > 0) ? ($homeXgTotal + $awayXgTotal) / $totalXgMatches : 0;
            $teamStats['xg'] = round($xg, 2);


            // Somma dei Goals Prevented
            $totalPrevented = $homePreventedTotal + $awayPreventedTotal;
            $teamStats['prevented'] = round($totalPrevented, 2);

            // Log per capire i valori prima dell'update
            Log::info("Aggiornamento xG e Prevented per la squadra {$team->name}: xG = {$teamStats['xg']}, Goals Prevented = {$teamStats['prevented']}");

            // Aggiornamento nel database
            try {
                $result = $team->forceFill($teamStats)->save();
                if (!$result) {
                    Log::error("Update fallito per il team {$team->name}");
                }

            } catch (\Exception $e) {
                Log::error("Errore durante l'aggiornamento delle statistiche per la squadra {$team->name}: {$e->getMessage()}");
            }
        }
    }
}
