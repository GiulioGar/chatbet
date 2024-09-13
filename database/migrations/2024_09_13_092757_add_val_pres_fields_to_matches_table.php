<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDecimalValPresFieldsToMatchesTable extends Migration
{
    /**
     * Esegui la migrazione.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->decimal('val_pres_h', 5, 2)->default(0); // Aggiungi val_pres_h come decimale (0-100, due cifre decimali)
            $table->decimal('val_pres_a', 5, 2)->default(0); // Aggiungi val_pres_a come decimale (0-100, due cifre decimali)
        });
    }

    /**
     * Reverti la migrazione.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn('val_pres_h'); // Rimuovi val_pres_h in caso di rollback
            $table->dropColumn('val_pres_a'); // Rimuovi val_pres_a in caso di rollback
        });
    }
}
