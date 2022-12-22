<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKodeMkToMataKuliahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            //
            $table->string('kode_mk')->nullable();
            $table->unsignedBigInteger('sks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mata_kuliahs', function (Blueprint $table) {
            //
            $table->dropColumn('kode_mk');
            $table->dropColumn('sks');
        });
    }
};
