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
            $table->unsignedBigInteger('id_dosen');
            $table->foreign('id_dosen')
                ->references('id_dosen')
                ->on('dosen')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('judul', 100);
            $table->date('mulai');
            $table->date('kumpul_sblm');
            $table->string('file_tugas_dosen')->nullable();
            $table->decimal('bobot', 5, 2)->nullable();
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
