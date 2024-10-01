<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewStatsColumnsToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Aggiunta delle colonne per over 1.5, 2.5, 3.5 e gol gol (gg) per casa e fuori casa
            $table->integer('h_over_1_5_ht')->default(0);
            $table->integer('a_over_1_5_ht')->default(0);
            $table->integer('h_over_1_5_ft')->default(0);
            $table->integer('a_over_1_5_ft')->default(0);

            $table->integer('h_over_2_5_ht')->default(0);
            $table->integer('a_over_2_5_ht')->default(0);
            $table->integer('h_over_2_5_ft')->default(0);
            $table->integer('a_over_2_5_ft')->default(0);

            $table->integer('h_over_3_5_ht')->default(0);
            $table->integer('a_over_3_5_ht')->default(0);
            $table->integer('h_over_3_5_ft')->default(0);
            $table->integer('a_over_3_5_ft')->default(0);

            $table->integer('h_gg_ht')->default(0);
            $table->integer('a_gg_ht')->default(0);
            $table->integer('h_gg_ft')->default(0);
            $table->integer('a_gg_ft')->default(0);
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
            // Rimozione delle colonne nel rollback della migrazione
            $table->dropColumn('h_over_1_5_ht');
            $table->dropColumn('a_over_1_5_ht');
            $table->dropColumn('h_over_1_5_ft');
            $table->dropColumn('a_over_1_5_ft');

            $table->dropColumn('h_over_2_5_ht');
            $table->dropColumn('a_over_2_5_ht');
            $table->dropColumn('h_over_2_5_ft');
            $table->dropColumn('a_over_2_5_ft');

            $table->dropColumn('h_over_3_5_ht');
            $table->dropColumn('a_over_3_5_ht');
            $table->dropColumn('h_over_3_5_ft');
            $table->dropColumn('a_over_3_5_ft');

            $table->dropColumn('h_gg_ht');
            $table->dropColumn('a_gg_ht');
            $table->dropColumn('h_gg_ft');
            $table->dropColumn('a_gg_ft');
        });
    }
}

