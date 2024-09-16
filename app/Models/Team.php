<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    // Aggiungi tutti i campi che vuoi rendere fillable
    protected $fillable = [
        'league_id',
        'name',
        'team_id', // Assicurati che sia presente se stai utilizzando un campo team_id
        't_played', 't_wins', 't_draws', 't_losses', 't_goals_for', 't_goals_against',
        't_shots_on_goal', 't_shots_off_goal', 't_total_shots', 't_saves', 't_fouls',
        't_corners', 't_yellow_cards', 't_red_cards', 't_ball_possession',
        'h_played', 'a_played', 'h_wins', 'a_wins', 'h_draws', 'a_draws',
        'h_losses', 'a_losses', 'h_goals_for', 'a_goals_for', 'h_goals_against', 'a_goals_against',
        'h_shots_on_goal', 'a_shots_on_goal', 'h_shots_off_goal', 'a_shots_off_goal',
        'h_total_shots', 'a_total_shots', 'h_saves', 'a_saves', 'h_fouls', 'a_fouls',
        'h_corners', 'a_corners', 'h_yellow_cards', 'a_yellow_cards', 'h_red_cards', 'a_red_cards',
        'h_ball_possession', 'a_ball_possession',
        't_over_0_5_ht', 't_over_0_5_ft', 't_over_1_5_ht', 't_over_1_5_ft',
        't_over_2_5_ht', 't_over_2_5_ft', 't_over_3_5_ht', 't_over_3_5_ft',
        't_gg_ht', 't_gg_ft','level', 'points',
        'goal_difference',
    ];


    // Definisci altre relazioni o metodi se necessario

    public function matches()
    {
        return Matches::where(function ($query) {
            $query->where('home_id', $this->team_id)
                  ->orWhere('away_id', $this->team_id);
        });
    }
}
