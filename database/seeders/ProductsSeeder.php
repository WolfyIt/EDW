<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_MX');

        // Lista de nombres de productos predefinidos
        $productNames = [
            'Laptop HP', 'Monitor Dell', 'Teclado Mecánico', 'Mouse Inalámbrico',
            'Auriculares Bluetooth', 'Impresora Epson', 'Escáner Canon', 'Webcam HD',
            'Disco Duro Externo', 'Memoria USB', 'Tarjeta de Memoria', 'Cable HDMI',
            'Cargador Universal', 'Batería Portátil', 'Router WiFi', 'Switch de Red',
            'Hub USB', 'Micrófono Profesional', 'Altavoz Bluetooth', 'Tableta Gráfica'
        ];

        // Crear 20 productos de ejemplo
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name' => $productNames[$i],
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat(2, 10, 1000),
                'stock' => $faker->numberBetween(0, 100),
            ]);
        }
    }
} 