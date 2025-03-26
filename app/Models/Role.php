<?php

// app/Models/Role.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // La tabla asociada con el modelo
    protected $table = 'roles';

    // Los atributos que son asignables
    protected $fillable = ['name'];

    // Relación con usuarios (un rol puede tener muchos usuarios)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

