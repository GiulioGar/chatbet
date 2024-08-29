<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveMatchesPlayedFromTeamsTable extends Migration
{
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('matches_played'); // Rimuove la colonna matches_played
        });
    }

    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->integer('matches_played')->default(0); // Ripristina la colonna matches_played
        });
    }
}
