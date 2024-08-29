
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatisticsToTeamsTable extends Migration
{
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Generali
            $table->integer('t_played')->default(0);         // Partite giocate totali
            $table->integer('t_wins')->default(0);           // Vittorie totali
            $table->integer('t_draws')->default(0);          // Pareggi totali
            $table->integer('t_losses')->default(0);         // Sconfitte totali
            $table->integer('t_goals_for')->default(0);      // Gol fatti totali
            $table->integer('t_goals_against')->default(0);  // Gol subiti totali
            $table->integer('t_shots_on_goal')->default(0);  // Tiri in porta totali
            $table->integer('t_shots_off_goal')->default(0); // Tiri fuori porta totali
            $table->integer('t_total_shots')->default(0);    // Tiri totali
            $table->integer('t_saves')->default(0);          // Parate totali
            $table->integer('t_fouls')->default(0);          // Falli totali
            $table->integer('t_corners')->default(0);        // Corner totali
            $table->integer('t_yellow_cards')->default(0);   // Cartellini gialli totali
            $table->integer('t_red_cards')->default(0);      // Cartellini rossi totali
            $table->float('t_ball_possession', 5, 2)->default(0); // Possesso palla totale

            // Specifici per casa e trasferta
            $table->integer('h_played')->default(0);         // Partite giocate in casa
            $table->integer('a_played')->default(0);         // Partite giocate fuori casa
            $table->integer('h_wins')->default(0);           // Vittorie in casa
            $table->integer('a_wins')->default(0);           // Vittorie fuori casa
            $table->integer('h_draws')->default(0);          // Pareggi in casa
            $table->integer('a_draws')->default(0);          // Pareggi fuori casa
            $table->integer('h_losses')->default(0);         // Sconfitte in casa
            $table->integer('a_losses')->default(0);         // Sconfitte fuori casa
            $table->integer('h_goals_for')->default(0);      // Gol fatti in casa
            $table->integer('a_goals_for')->default(0);      // Gol fatti fuori casa
            $table->integer('h_goals_against')->default(0);  // Gol subiti in casa
            $table->integer('a_goals_against')->default(0);  // Gol subiti fuori casa
            $table->integer('h_shots_on_goal')->default(0);  // Tiri in porta in casa
            $table->integer('a_shots_on_goal')->default(0);  // Tiri in porta fuori casa
            $table->integer('h_shots_off_goal')->default(0); // Tiri fuori porta in casa
            $table->integer('a_shots_off_goal')->default(0); // Tiri fuori porta fuori casa
            $table->integer('h_total_shots')->default(0);    // Tiri totali in casa
            $table->integer('a_total_shots')->default(0);    // Tiri totali fuori casa
            $table->integer('h_saves')->default(0);          // Parate in casa
            $table->integer('a_saves')->default(0);          // Parate fuori casa
            $table->integer('h_fouls')->default(0);          // Falli in casa
            $table->integer('a_fouls')->default(0);          // Falli fuori casa
            $table->integer('h_corners')->default(0);        // Corner in casa
            $table->integer('a_corners')->default(0);        // Corner fuori casa
            $table->integer('h_yellow_cards')->default(0);   // Cartellini gialli in casa
            $table->integer('a_yellow_cards')->default(0);   // Cartellini gialli fuori casa
            $table->integer('h_red_cards')->default(0);      // Cartellini rossi in casa
            $table->integer('a_red_cards')->default(0);      // Cartellini rossi fuori casa
            $table->float('h_ball_possession', 5, 2)->default(0); // Possesso palla in casa
            $table->float('a_ball_possession', 5, 2)->default(0); // Possesso palla fuori casa

            // Over HT e FT
            $table->integer('t_over_0_5_ht')->default(0); // Over 0.5 HT totali
            $table->integer('t_over_0_5_ft')->default(0); // Over 0.5 FT totali
            $table->integer('t_over_1_5_ht')->default(0); // Over 1.5 HT totali
            $table->integer('t_over_1_5_ft')->default(0); // Over 1.5 FT totali
            $table->integer('t_over_2_5_ht')->default(0); // Over 2.5 HT totali
            $table->integer('t_over_2_5_ft')->default(0); // Over 2.5 FT totali
            $table->integer('t_over_3_5_ht')->default(0); // Over 3.5 HT totali
            $table->integer('t_over_3_5_ft')->default(0); // Over 3.5 FT totali
            $table->integer('t_gg_ht')->default(0);       // Gol Gol HT totali
            $table->integer('t_gg_ft')->default(0);       // Gol Gol FT totali
        });
    }

    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Usa hasColumn per verificare se le colonne esistono prima di rimuoverle
            $columns = [
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
                't_gg_ht', 't_gg_ft'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('teams', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
}
