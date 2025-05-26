<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok', function (Blueprint $table) {
            $table->bigIncrements('id_klp', 8);
            $table->bigInteger('id_dosen')->unsigned()->nullable();
            $table->foreign('id_dosen')->references('id_dosen')->on('dosen')->onUpdate('cascade')->onDelete('cascade');
            $table->char('nim1', 8)->unique();
            $table->foreign('nim1')->references('nim')->on('mahasiswa')->onUpdate('cascade')->onDelete('cascade');
            $table->char('nim2', 8)->unique();
            $table->foreign('nim2')->references('nim')->on('mahasiswa')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelompok');
    }
}
