<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'customer_number',
    ];

    protected static function booted()
    {
        static::created(function (Customer $customer) {
            $customer->updateQuietly([
                'customer_number' => 'CUST' . str_pad($customer->id, 6, '0', STR_PAD_LEFT),
            ]);
        });
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}