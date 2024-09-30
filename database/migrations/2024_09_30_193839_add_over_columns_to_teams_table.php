<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOverColumnsToTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            // Colonne per Over 1.5
            $table->integer('h_over_1_5')->nullable()->comment('Over 1.5 per le partite in casa');
            $table->integer('a_over_1_5')->nullable()->comment('Over 1.5 per le partite fuori casa');
            $table->integer('t_over_1_5')->nullable()->comment('Totale Over 1.5');

            // Colonne per Over 2.5
            $table->integer('h_over_2_5')->nullable()->comment('Over 2.5 per le partite in casa');
            $table->integer('a_over_2_5')->nullable()->comment('Over 2.5 per le partite fuori casa');
            $table->integer('t_over_2_5')->nullable()->comment('Totale Over 2.5');

            // Colonne per Over 3.5
            $table->integer('h_over_3_5')->nullable()->comment('Over 3.5 per le partite in casa');
            $table->integer('a_over_3_5')->nullable()->comment('Over 3.5 per le partite fuori casa');
            $table->integer('t_over_3_5')->nullable()->comment('Totale Over 3.5');

            // Colonne per Gol Gol
            $table->integer('h_gg')->nullable()->comment('Gol Gol per le partite in casa');
            $table->integer('a_gg')->nullable()->comment('Gol Gol per le partite fuori casa');
            $table->integer('t_gg')->nullable()->comment('Totale Gol Gol');
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
            $table->dropColumn([
                'h_over_1_5', 'a_over_1_5', 't_over_1_5',
                'h_over_2_5', 'a_over_2_5', 't_over_2_5',
                'h_over_3_5', 'a_over_3_5', 't_over_3_5',
                'h_gg', 'a_gg', 't_gg'
            ]);
        });
    }
}
