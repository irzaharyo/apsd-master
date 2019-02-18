<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->integer('jenis_id')->unsigned();
            $table->foreign('jenis_id')->references('id')->on('jenis_surats')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->date('tgl_surat')->nullable();
            $table->string('nama_penerima');
            $table->string('kota_penerima');
            $table->string('no_surat')->nullable();
            $table->string('sifat_surat')->nullable();
            $table->string('lampiran')->nullable();
            $table->string('perihal');
            $table->text('isi')->nullable();
            $table->integer('status')->default(0);
            $table->text('files')->nullable();
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
        Schema::dropIfExists('surat_keluars');
    }
}
