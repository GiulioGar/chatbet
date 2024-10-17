<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->integer('h_over_0_5_ht')->default(0);
            $table->integer('a_over_0_5_ht')->default(0);
        });
    }

    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('h_over_0_5_ht');
            $table->dropColumn('a_over_0_5_ht');
        });
    }

};
