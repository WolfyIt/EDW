<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id', 'payload', 'last_activity'];

    // Relación con User (cada sesión pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
