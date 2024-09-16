<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpectedGoalsAndGoalsPreventedToMatchesTable extends Migration
{
    /**
     * Esegui la migrazione.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('matches', function (Blueprint $table) {
        //     $table->decimal('expected_goalsH', 5, 2)->nullable();
        //     $table->decimal('goals_preventedH', 5, 2)->nullable();
        // });
    }

    /**
     * Reverti la migrazione.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('matches', function (Blueprint $table) {
        //     $table->dropColumn('expected_goals');
        //     $table->dropColumn('goals_prevented');
        // });
    }
}
