<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('cache', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->integer('expiration');  // Agregar la columna expiration
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('cache');
    }
};



