<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArchivioMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('archivio_matches', function (Blueprint $table) {
            $table->id();
            $table->string('season', 10); // Esempio: 2023
            $table->unsignedBigInteger('league_id'); // Esempio: 39
            $table->string('division', 10); // Esempio: E0
            $table->date('match_date'); // Esempio: 11/08/2023
            $table->time('match_time'); // Esempio: 20:00
            $table->string('home_name'); // Esempio: Burnley
            $table->string('away_name'); // Esempio: Man City
            $table->unsignedBigInteger('home_id'); // Esempio: 44
            $table->unsignedBigInteger('away_id'); // Esempio: 50
            $table->integer('home_score')->nullable(); // Esempio: 0
            $table->integer('away_score')->nullable(); // Esempio: 3
            $table->char('full_result', 1)->nullable(); // Esempio: A (Risultato finale)
            $table->integer('home_ht')->nullable(); // Esempio: 0 (Gol alla fine del primo tempo per la squadra di casa)
            $table->integer('away_ht')->nullable(); // Esempio: 2 (Gol alla fine del primo tempo per la squadra ospite)
            $table->char('half_result', 1)->nullable(); // Esempio: A (Risultato a metà partita)
            $table->integer('tsh_home')->nullable(); // Esempio: 6 (Tiri totali della squadra di casa)
            $table->integer('tsh_away')->nullable(); // Esempio: 17 (Tiri totali della squadra ospite)
            $table->integer('sog_home')->nullable(); // Esempio: 1 (Tiri in porta della squadra di casa)
            $table->integer('sog_away')->nullable(); // Esempio: 8 (Tiri in porta della squadra ospite)
            $table->integer('fouls_home')->nullable(); // Esempio: 11 (Falli commessi dalla squadra di casa)
            $table->integer('fouls_away')->nullable(); // Esempio: 8 (Falli commessi dalla squadra ospite)
            $table->integer('corners_home')->nullable(); // Esempio: 6 (Calci d'angolo per la squadra di casa)
            $table->integer('corners_away')->nullable(); // Esempio: 5 (Calci d'angolo per la squadra ospite)
            $table->integer('yc_home')->nullable(); // Esempio: 0 (Cartellini gialli per la squadra di casa)
            $table->integer('yc_away')->nullable(); // Esempio: 0 (Cartellini gialli per la squadra ospite)
            $table->integer('rc_home')->nullable(); // Esempio: 1 (Cartellini rossi per la squadra di casa)
            $table->integer('rc_away')->nullable(); // Esempio: 0 (Cartellini rossi per la squadra ospite)
            $table->timestamps(); // Created at and updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('archivio_matches');
    }
}

