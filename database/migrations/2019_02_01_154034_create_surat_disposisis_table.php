<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratDisposisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_disposisis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('suratmasuk_id')->unsigned();
            $table->foreign('suratmasuk_id')->references('id')->on('surat_masuks')
                ->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->string('diteruskan_kepada');
            $table->string('harapan');
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('surat_disposisis');
    }
}
