<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // id auto_increment
            $table->string('name', 100); // nombre del usuario
            $table->string('email', 100)->unique(); // email único
            $table->string('password'); // contraseña
            $table->unsignedBigInteger('role_id')->nullable(); // referencia al rol (foreign key)
            $table->timestamps(); // created_at y updated_at
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null'); // foreign key
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}

