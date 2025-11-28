<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Service extends Model
{
    // RF C2: Datos del catálogo
    protected $fillable = [
        'name', 
        'description', 
        'duration_minutes', 
        'price', 
        'category', 
        'is_active'
    ];

    // Relación: Un servicio puede estar en muchas citas (Muchos a Muchos)
    public function appointments()
    {
        return $this->belongsToMany(Appointment::class)
                    ->withPivot('price_at_booking') // Guardamos el precio histórico
                    ->withTimestamps();
    }
}