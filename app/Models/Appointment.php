<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    // Define quais campos podem ser salvos em massa
    protected $fillable = [
        'client_id',
        'provider_id',
        'appointment_date',
        'location',
        'status',
    ];

    // Relacionamento: O agendamento pertence a um Cliente (Usuário de Descarte)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relacionamento: O agendamento também pertence a um Prestador (Empresa de Coleta)
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}