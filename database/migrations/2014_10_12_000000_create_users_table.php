<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->text('ava')->nullable();
            $table->string('nip', 18)->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role', 30);
            $table->rememberToken();
            $table->string('jabatan')->nullable();
            $table->string('alamat')->nullable();
            $table->string('nmr_hp')->nullable();
            $table->string('jk')->nullable();
            $table->double('lat', 20, 10)->nullable();
            $table->double('long', 20, 10)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
