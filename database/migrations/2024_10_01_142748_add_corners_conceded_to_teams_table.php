<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCornersConcededToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Aggiungi i nuovi campi per i corner subiti
            $table->integer('t_corners_conceded')->default(0)->nullable(); // Totali
            $table->integer('h_corners_conceded')->default(0)->nullable(); // Casa
            $table->integer('a_corners_conceded')->default(0)->nullable(); // Fuori casa
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Rimuovi i campi aggiunti per i corner subiti
            $table->dropColumn('t_corners_conceded');
            $table->dropColumn('h_corners_conceded');
            $table->dropColumn('a_corners_conceded');
        });
    }
}
