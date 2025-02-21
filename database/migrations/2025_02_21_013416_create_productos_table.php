<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); // id auto_increment
            $table->string('name', 100)->unique(); // nombre del producto único
            $table->text('description'); // descripción
            $table->integer('stock'); // cantidad en stock
            $table->decimal('price', 10, 2); // precio
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
