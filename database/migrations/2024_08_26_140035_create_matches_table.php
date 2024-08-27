<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('league_id'); // ID del campionato
            $table->integer('home_id'); // ID squadra di casa
            $table->integer('away_id'); // ID squadra ospite
            $table->date('match_date'); // Data della partita
            $table->time('match_time')->nullable(); // Ora della partita
            $table->integer('home_score')->nullable(); // Punteggio squadra di casa
            $table->integer('away_score')->nullable(); // Punteggio squadra ospite
            $table->integer('home_ht')->nullable(); // Punteggio primo tempo squadra di casa
            $table->integer('away_ht')->nullable(); // Punteggio primo tempo squadra ospite
            $table->integer('home_ft')->nullable(); // Punteggio secondo tempo squadra di casa
            $table->integer('away_ft')->nullable(); // Punteggio secondo tempo squadra ospite
            $table->string('referee')->nullable(); // Nome dell'arbitro
            $table->integer('sog_home')->nullable();    // Shots on Goal Home
            $table->integer('sog_away')->nullable();    // Shots on Goal Away
            $table->integer('sof_home')->nullable();    // Shots off Goal Home
            $table->integer('sof_away')->nullable();    // Shots off Goal Away
            $table->integer('sib_home')->nullable();    // Shots inside box Home
            $table->integer('sib_away')->nullable();    // Shots inside box Away
            $table->integer('sob_home')->nullable();    // Shots outside box Home
            $table->integer('sob_away')->nullable();    // Shots outside box Away
            $table->integer('tsh_home')->nullable();    // Total Shots Home
            $table->integer('tsh_away')->nullable();    // Total Shots Away
            $table->integer('blk_home')->nullable();    // Blocked Shots Home
            $table->integer('blk_away')->nullable();    // Blocked Shots Away
            $table->integer('fouls_home')->nullable();  // Fouls Home
            $table->integer('fouls_away')->nullable();  // Fouls Away
            $table->integer('corners_home')->nullable();// Corner Kicks Home
            $table->integer('corners_away')->nullable();// Corner Kicks Away
            $table->integer('offsides_home')->nullable();// Offsides Home
            $table->integer('offsides_away')->nullable();// Offsides Away
            $table->string('possession_home')->nullable(); // Ball Possession Home
            $table->string('possession_away')->nullable(); // Ball Possession Away
            $table->integer('yc_home')->nullable();     // Yellow Cards Home
            $table->integer('yc_away')->nullable();     // Yellow Cards Away
            $table->integer('rc_home')->nullable();     // Red Cards Home
            $table->integer('rc_away')->nullable();     // Red Cards Away
            $table->integer('saves_home')->nullable();  // Goalkeeper Saves Home
            $table->integer('saves_away')->nullable();  // Goalkeeper Saves Away
            $table->integer('tpass_home')->nullable();  // Total Passes Home
            $table->integer('tpass_away')->nullable();  // Total Passes Away
            $table->integer('pacc_home')->nullable();   // Passes Accurate Home
            $table->integer('pacc_away')->nullable();   // Passes Accurate Away
            $table->string('pperc_home')->nullable();   // Passes % Home
            $table->string('pperc_away')->nullable();   // Passes % Away
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
