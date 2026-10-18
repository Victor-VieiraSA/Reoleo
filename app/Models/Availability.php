<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    // Define quais campos podem ser salvos em massa
    protected $fillable = [
        'provider_id',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    // Relacionamento: Uma disponibilidade pertence a uma Empresa de Coleta (User)
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}