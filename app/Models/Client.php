<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // RF B1: Datos del cliente permitidos
    protected $fillable = [
        'name', 
        'last_name', 
        'email', 
        'phone', 
        'alias', 
        'cedula'
    ];

    // Relación: Un cliente tiene muchas citas (RF D2: Historial)
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
