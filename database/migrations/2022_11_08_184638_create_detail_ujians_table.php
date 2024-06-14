<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailUjiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_ujian', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->longText('soal');
            $table->string('pg_1');
            $table->string('pg_2');
            $table->string('pg_3');
            $table->string('pg_4');
            $table->string('pg_5');
            $table->string('jawaban');
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
        Schema::dropIfExists('detail_ujians');
    }
}
