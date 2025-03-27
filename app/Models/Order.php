<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'customer_number',
        'fiscal_data',
        'created_at',
        'delivery_address',
        'notes',
        'status',
        'photo_path',
        'order_date'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'order_date'
    ];
}


