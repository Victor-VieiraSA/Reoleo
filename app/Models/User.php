<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Define quais campos podem ser salvos em massa
    protected $fillable = [
        'name',
        'email',
        'password',
        'cnpj',
        'role',
    ];

    // Oculta campos sensíveis ao retornar os dados em JSON (na API)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Define os tipos das colunas
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relacionamento: Um usuário (Admin) tem várias campanhas/materiais
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'creator_id');
    }

    // Relacionamento: Uma empresa de coleta tem várias disponibilidades
    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'provider_id');
    }

    // Relacionamento: Um usuário de descarte tem vários agendamentos
    public function appointmentsAsClient()
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    // Relacionamento: Uma empresa de coleta recebe vários agendamentos
    public function appointmentsAsProvider()
    {
        return $this->hasMany(Appointment::class, 'provider_id');
    }
}