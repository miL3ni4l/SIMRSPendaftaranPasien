<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntriansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_antrian');
            $table->integer('pasien_id')->unsigned();
            $table->foreign('pasien_id')->references('id')->on('pasien')->onDelete('cascade');
            $table->integer('dokter_id')->unsigned();
            $table->foreign('dokter_id')->references('id')->on('dokter')->onDelete('cascade');
            $table->date('tgl_antrian');
            $table->string('jam');
            $table->string('poli');
            $table->enum('status', ['pasien lama', 'pasien baru']);
            $table->text('ket')->nullable();
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
        Schema::dropIfExists('antrian');
    }
}
