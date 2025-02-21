<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesPedidoTable extends Migration
{
    public function up()
    {
        Schema::create('detalles_pedido', function (Blueprint $table) {
            $table->id(); // id auto_increment
            $table->unsignedBigInteger('order_id'); // id del pedido
            $table->unsignedBigInteger('product_id'); // id del producto
            $table->integer('quantity'); // cantidad
            $table->timestamps(); // created_at y updated_at
            $table->foreign('order_id')->references('id')->on('pedidos')->onDelete('cascade'); // foreign key a pedidos
            $table->foreign('product_id')->references('id')->on('productos')->onDelete('cascade'); // foreign key a productos
        });
    }

    public function down()
    {
        Schema::dropIfExists('detalles_pedido');
    }
}
