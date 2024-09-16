<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPointsAndGoalDifferenceToTeamsTable extends Migration
{
    /**
     * Esegui la migrazione.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->integer('points')->default(0);
            $table->integer('goal_difference')->default(0);
        });
    }

    /**
     * Reverti la migrazione.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('points');
            $table->dropColumn('goal_difference');
        });
    }
}
