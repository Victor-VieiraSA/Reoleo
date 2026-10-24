<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AvailabilityApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_deve_criar_disponibilidade_para_empresa()
    {
        // 1. Cria um usuário com perfil de Empresa de Coleta
        $provider = User::create([
            'name' => 'Eco Óleo Coletas',
            'email' => 'contato@ecooleo.com',
            'password' => bcrypt('senha123'),
            'role' => 'Empresa_Coleta'
        ]);

        // 2. Dispara a requisição POST simulando o cadastro de horário
        $response = $this->postJson('/api/availabilities', [
            'provider_id' => $provider->id,
            'day_of_week' => 1, // Segunda-feira
            'start_time' => '08:00',
            'end_time' => '18:00'
        ]);

        // 3. Verifica se retornou sucesso (201 Created) e se salvou no banco
        $response->assertStatus(201);
        
        $this->assertDatabaseHas('availabilities', [
            'provider_id' => $provider->id,
            'day_of_week' => 1,
            'start_time' => '08:00', // O banco costuma salvar com os segundos
        ]);
    }
}