<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyExpectedGoalsAndAddNewFieldsToMatchesTable extends Migration
{
    /**
     * Esegui la migrazione.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('matches', function (Blueprint $table) {
        //     // Aggiungi nuovi campi
        //     $table->decimal('expected_goalsA', 5, 2)->nullable();
        //     $table->decimal('goals_preventedA', 5, 2)->nullable();
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
        //     // Elimina i campi aggiunti
        //     $table->dropColumn('expected_goalsA');
        //     $table->dropColumn('goals_preventedA');
        // });
    }
}
