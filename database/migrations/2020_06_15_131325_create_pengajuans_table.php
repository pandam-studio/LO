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

            $table->increments('Id_pengajuan');
            $table->unsignedInteger('Id_alumni');
            $table->foreign('Id_alumni')->references('Id_alumni')->on('Alumni')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('Id_status');
            $table->foreign('Id_status')->references('Id_status')->on('Status')->onDelete('cascade')->onUpdate('cascade');
            $table->date('Tgl_masuk')->nullable();
            $table->date('Tgl_dekan')->nullable();
            $table->date('Tgl_siap_diambil')->nullable();
            $table->date('Tgl_keluar')->nullable();
            $table->string('Code', 5)->unique();

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
