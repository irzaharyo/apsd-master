<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaKeluarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_keluars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('suratkeluar_id')->unsigned();
            $table->foreign('suratkeluar_id')->references('id')->on('surat_keluars')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('ringkasan');
            $table->string('keterangan');
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
        Schema::dropIfExists('agenda_keluars');
    }
}
