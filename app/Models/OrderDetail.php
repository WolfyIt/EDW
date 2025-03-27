<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Relación con Order (cada detalle pertenece a un pedido)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación con Product (cada detalle pertenece a un producto)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
