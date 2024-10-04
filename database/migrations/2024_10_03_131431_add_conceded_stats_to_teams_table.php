<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('teams', function (Blueprint $table) {
        // Tiri concessi
        $table->integer('sog_conc_h')->default(0)->nullable();
        $table->integer('sog_conc_a')->default(0)->nullable();
        $table->integer('sof_conc_h')->default(0)->nullable();
        $table->integer('sof_conc_a')->default(0)->nullable();
        $table->integer('sib_conc_h')->default(0)->nullable();
        $table->integer('sib_conc_a')->default(0)->nullable();
        $table->integer('sob_conc_h')->default(0)->nullable();
        $table->integer('sob_conc_a')->default(0)->nullable();
        $table->integer('tsh_conc_h')->default(0)->nullable();
        $table->integer('tsh_conc_a')->default(0)->nullable();

        // Falli e cartellini concessi
        $table->integer('fouls_conc_h')->default(0)->nullable();
        $table->integer('fouls_conc_a')->default(0)->nullable();
        $table->integer('yc_conc_h')->default(0)->nullable();
        $table->integer('yc_conc_a')->default(0)->nullable();
        $table->integer('rc_conc_h')->default(0)->nullable();
        $table->integer('rc_conc_a')->default(0)->nullable();
    });
}

public function down()
{
    Schema::table('teams', function (Blueprint $table) {
        // Drop the columns if we rollback
        $table->dropColumn([
            'sog_conc_h', 'sog_conc_a', 'sof_conc_h', 'sof_conc_a',
            'sib_conc_h', 'sib_conc_a', 'sob_conc_h', 'sob_conc_a',
            'tsh_conc_h', 'tsh_conc_a', 'fouls_conc_h', 'fouls_conc_a',
            'yc_conc_h', 'yc_conc_a', 'rc_conc_h', 'rc_conc_a'
        ]);
    });
}

};
