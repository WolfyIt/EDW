<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id(); // id auto_increment
            $table->string('invoice_number', 50)->unique(); // número de factura único
            $table->string('customer_name', 100); // nombre del cliente
            $table->string('customer_number', 50)->unique(); // número del cliente único
            $table->text('fiscal_data'); // datos fiscales
            $table->dateTime('order_date'); // fecha de pedido
            $table->text('delivery_address'); // dirección de entrega
            $table->text('notes')->nullable(); // notas opcionales
            $table->enum('status', ['Ordered', 'In Process', 'In Route', 'Delivered'])->default('Ordered'); // estado
            $table->boolean('is_deleted')->default(false); // si está eliminado
            $table->timestamps(); // created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
