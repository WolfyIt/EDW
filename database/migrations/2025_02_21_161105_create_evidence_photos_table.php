<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('evidence_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->enum('photo_type', ['Loaded', 'Delivered']); // Foto de carga o de entrega
            $table->string('photo_path'); // Ruta de la imagen en el almacenamiento
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('evidence_photos');
    }
};

