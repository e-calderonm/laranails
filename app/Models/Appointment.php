<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Appointment extends Model
{
    protected $fillable = [
        'user_id', 
        'client_id', 
        'date', 
        'start_time', 
        'end_time', 
        'total_duration_minutes', 
        'total_price', 
        'status', 
        'notes'
    ];

    // Relación: Pertenece a un Usuario (RF A4)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Pertenece a un Cliente (RF A2)
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación: Tiene MUCHOS servicios (RF A3)
    public function services()
    {
        return $this->belongsToMany(Service::class)
                    ->withPivot('price_at_booking')
                    ->withTimestamps();
    }
}