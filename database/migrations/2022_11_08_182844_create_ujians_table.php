<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->integer('instruktur_id');
            $table->integer('pelatihan_id');
            $table->bigInteger('gelombang_id');
            $table->integer('mapel_id');
            $table->integer('jam');
            $table->integer('menit');
            $table->integer('acak');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujians');
    }
}
