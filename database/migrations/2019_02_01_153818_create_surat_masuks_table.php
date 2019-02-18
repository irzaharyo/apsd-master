<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('jenis_id')->unsigned();
            $table->foreign('jenis_id')->references('id')->on('jenis_surats')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->date('tgl_surat');
            $table->string('no_surat');
            $table->string('sifat_surat');
            $table->string('lampiran');
            $table->string('perihal');
            $table->string('nama_instansi');
            $table->string('asal_instansi');
            $table->string('nama_pengirim');
            $table->string('jabatan_pengirim');
            $table->string('nip_pengirim');
            $table->text('tembusan');
            $table->text('files');
            $table->boolean('isDisposisi')->default(false);
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
        Schema::dropIfExists('surat_masuks');
    }
}
