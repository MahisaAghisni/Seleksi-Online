<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password');
            $table->string('email');
            $table->timestamp('regdate');
            $table->string('ip', 39);
            $table->string('ktp', 20);
            $table->string('firstname');
            $table->date('birthdate');
            $table->string('birthplace');
            $table->smallInteger('role');
            $table->integer('jk');
            $table->string('alamat');
            $table->string('agama', 25);
            $table->string('hp', 15);
            $table->string('pendidikan', 25);
            $table->string('pendidikan_now', 25);
            $table->string('jurusan');
            $table->string('asalsekolah');
            $table->integer('pelatihan');
            $table->string('fcktp');
            $table->string('fcijazah');
            $table->string('is_active', 1);
            $table->bigInteger('idGelombang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesertas');
    }
}
