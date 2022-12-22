<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdMkToDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('data', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_mk')->nullable();
            $table->foreign('id_mk')->references('id')->on('mata_kuliahs')->onDelete('cascade');
            
        });

        Schema::table('jadwals', function (Blueprint $table) {
            //
            $table->dropForeign('jadwals_id_mata_kuliah_foreign');
            $table->dropColumn('id_mata_kuliah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data', function (Blueprint $table) {
            //
            $table->dropForeign('jadwals_id_mk_foreign');
            $table->dropColumn('id_mk');
            
        });

        Schema::table('jadwals', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_mata_kuliah')->nullable();
            $table->foreign('id_mata_kuliah')->references('id')->on('mata_kuliahs')->onDelete('cascade');
        });
    }
};
