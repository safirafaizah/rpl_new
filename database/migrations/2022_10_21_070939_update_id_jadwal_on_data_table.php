<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateIdJadwalOnDataTable extends Migration
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
            $table->dropForeign('data_id_jadwal_foreign');
            $table->dropColumn('id_jadwal');
        });

        Schema::table('jadwals', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('id_data')->nullable();
            $table->foreign('id_data')->references('id')->on('data')->onDelete('cascade');
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
            $table->unsignedBigInteger('id_jadwal')->nullable();
            $table->foreign('id_jadwal')->references('id')->on('jadwals')->onDelete('cascade');
        });

        Schema::table('jadwals', function (Blueprint $table) {
            //
            $table->dropForeign('data_id_data_foreign');
            $table->dropColumn('id_data');
        });
    }
};
