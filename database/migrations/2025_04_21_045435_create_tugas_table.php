<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->bigIncrements('id_tugas');
            $table->bigInteger('id_dosen')->unsigned();
            $table->foreign('id_dosen')->references('id_dosen')->on('dosen')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('id_klp')->unsigned();
            $table->foreign('id_klp')->references('id_klp')->on('kelompok')->onUpdate('cascade')->onDelete('cascade');
            $table->string('judul', 100);
            $table->date('mulai');
            $table->date('kumpul_sblm');
            $table->string('aktivitas', 100);
            $table->string('file_tugas_dosen')->nullable();
            $table->string('file_tugas_mhs')->nullable();
            $table->decimal('nilai')->nullable();
            $table->decimal('bobot', 5, 2)->nullable();
            $table->decimal('capaian_maksimal')->nullable();
            $table->string('nilai_huruf', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tugas');
    }
}
