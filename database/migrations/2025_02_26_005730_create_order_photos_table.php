<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('order_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('photo_path');
            $table->enum('type', ['loaded', 'delivered']);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('order_photos');
    }
};

