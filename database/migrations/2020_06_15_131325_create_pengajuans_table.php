<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pengajuan', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id('Id_pengajuan')->autoIncrement();
            $table->unsignedBigInteger('Id_alumni');
            $table->foreign('Id_alumni')->references('Id_alumni')->on('Alumni');
            $table->unsignedBigInteger('Id_status');
            $table->foreign('Id_status')->references('Id_status')->on('status');
            $table->date('Tgl_masuk')->nullable();
            $table->date('Tgl_keluar')->nullable();

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuans');
    }
}
