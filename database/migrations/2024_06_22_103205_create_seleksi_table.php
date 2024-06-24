<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeleksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seleksi', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idGelombang');
            $table->bigInteger('idPelatihan');
            $table->bigInteger('idUjian');
            $table->date('tanggal');
            $table->time('jam');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seleksi');
    }
}
