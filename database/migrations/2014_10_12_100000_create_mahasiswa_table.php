<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->char('nim', 8)->primary();
            $table->string('nama_mhs', 50);
            $table->enum('status_mengulang', ['mengulang', 'tidak_mengulang']);
            $table->enum('dosen_sebelum', [
                'Aloysius Airlangga Bajuadji, S.Kom., M.Eng.',
                'Andhika Galuh Prabawati, S.Kom., M.Kom.',
                'Andreas Satyo Aji Nugroho, S.Kom.',
                'Argo Wibowo, S.T., M.T.',
                'Lussy Ernawati, S.Kom., M.Acc',
                'Wilson Nasumi Mili, S.Kom., M.T.',
                'Yetli Oslan, S.Kom, M.T.'
            ])->nullable();
            $table->bigInteger('id_user')->unsigned();
            $table->foreign('id_user')->references('id_user')->on('user')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
