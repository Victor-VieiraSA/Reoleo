<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AppointmentApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_deve_criar_um_agendamento_com_estimativa_de_oleo()
    {
        // 1. Prepara o cenário: Cria um cliente e uma empresa
        $client = User::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@teste.com',
            'password' => bcrypt('senha123'),
            'role' => 'Usuario_Descarte'
        ]);

        $provider = User::create([
            'name' => 'Empresa Teste',
            'email' => 'empresa@teste.com',
            'password' => bcrypt('senha123'),
            'role' => 'Empresa_Coleta'
        ]);

        // 2. Ação: Tenta criar o agendamento via API
        $response = $this->postJson('/api/appointments', [
            'client_id' => $client->id,
            'provider_id' => $provider->id,
            'appointment_date' => '2026-11-05 14:00:00',
            'location' => 'Rua das Flores, 123',
            'oil_estimate' => 10.5
        ]);

        // 3. Verificação: Garante que deu certo (201) e que salvou numérico
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('appointments', [
            'client_id' => $client->id,
            'oil_estimate' => 10.5,
            'status' => 'Agendado'
        ]);
    }
}