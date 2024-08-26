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
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
