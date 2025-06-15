<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTugasKelompokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tugas_kelompok', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tugas');
            $table->foreign('id_tugas')
                ->references('id_tugas')
                ->on('tugas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->unsignedBigInteger('id_klp');
            $table->foreign('id_klp')
                ->references('id_klp')
                ->on('kelompok')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('file_tugas_mhs')->nullable();
            $table->char('nim_pengumpul', 8)->nullable();
            $table->timestamp('waktu_kumpul')->nullable();
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
        Schema::dropIfExists('tugas_kelompok');
    }
}
