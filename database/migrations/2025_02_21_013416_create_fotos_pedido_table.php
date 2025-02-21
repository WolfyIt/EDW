<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosPedidoTable extends Migration
{
    public function up()
    {
        Schema::create('fotos_pedido', function (Blueprint $table) {
            $table->id(); // id auto_increment
            $table->unsignedBigInteger('order_id'); // id del pedido
            $table->string('photo_path'); // ruta de la foto
            $table->enum('photo_type', ['loaded', 'delivered']); // tipo de foto
            $table->timestamps(); // created_at y updated_at
            $table->foreign('order_id')->references('id')->on('pedidos')->onDelete('cascade'); // foreign key a pedidos
        });
    }

    public function down()
    {
        Schema::dropIfExists('fotos_pedido');
    }
}

