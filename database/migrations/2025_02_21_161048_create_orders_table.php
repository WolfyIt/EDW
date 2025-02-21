<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->string('customer_name');
            $table->string('customer_number')->unique();
            $table->string('fiscal_data');
            $table->dateTime('order_date');
            $table->text('delivery_address');
            $table->text('notes')->nullable();
            $table->enum('status', ['Ordered', 'In process', 'In route', 'Delivered'])->default('Ordered');
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('orders');
    }
};

