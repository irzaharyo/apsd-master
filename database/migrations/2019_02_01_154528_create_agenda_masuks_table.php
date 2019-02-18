<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendaMasuksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agenda_masuks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('suratdisposisi_id')->unsigned();
            $table->foreign('suratdisposisi_id')->references('id')->on('surat_disposisis')
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
        Schema::dropIfExists('agenda_masuks');
    }
}
