<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class CampaignApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_deve_criar_uma_campanha_informativa()
    {
        // 1. Cria um usuário (simulando um Admin)
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@reoleo.com',
            'password' => bcrypt('senha123'),
            'role' => 'Admin'
        ]);

        // 2. Envia os dados da campanha para a API
        $response = $this->postJson('/api/campaigns', [
            'creator_id' => $admin->id,
            'title' => 'Como descartar óleo corretamente',
            'content' => 'Espere esfriar e armazene em garrafas PET.',
            'topic' => 'Descarte Consciente'
        ]);

        // 3. Valida se a criação funcionou
        $response->assertStatus(201);

        $this->assertDatabaseHas('campaigns', [
            'creator_id' => $admin->id,
            'title' => 'Como descartar óleo corretamente'
        ]);
    }

    public function test_deve_listar_campanhas()
    {
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@reoleo.com',
            'password' => bcrypt('senha123'),
            'role' => 'Admin'
        ]);

        // Cria a campanha diretamente no banco para o teste
        $this->postJson('/api/campaigns', [
            'creator_id' => $admin->id,
            'title' => 'Reciclagem de Óleo',
            'content' => 'Conteúdo da campanha...',
            'topic' => 'Reciclagem'
        ]);

        // Testa a leitura (GET)
        $response = $this->getJson('/api/campaigns');

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Reciclagem de Óleo']);
    }
}