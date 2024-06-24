<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGelombangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gelombangs', function (Blueprint $table) {
            $table->id('idGelombang');
            $table->bigInteger('tahun');
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->date('tgl_seleksi_awal');
            $table->date('tgl_seleksi_akhir');
            $table->string('gelombang');
            $table->integer('anggaran');
            $table->integer('jenis');
            $table->string('status', 15);
            $table->string('create_user');
            $table->dateTime('create_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gelombangs');
    }
}
