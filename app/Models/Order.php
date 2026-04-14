<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'customer_number',
        'invoice_number',
        'customer_id',
        'user_id',
        'status',
        'total_amount',
        'notes',
        'archived',              // added archived flag
        'photo_delivered',       // photo when order is delivered
        'image_path',            // photo during processing
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_PROCESSING,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    /**
     * Calculate the total amount of the order based on its products
     *
     * @return float
     */
    public function calculateTotal()
    {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product->pivot->price * $product->pivot->quantity;
        }
        return $total;
    }

    /**
     * Update the total amount of the order based on its products
     *
     * @return void
     */
    public function updateTotal()
    {
        $this->total_amount = $this->calculateTotal();
        $this->save();
    }
}


