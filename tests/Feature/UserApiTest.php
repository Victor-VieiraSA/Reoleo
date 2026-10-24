<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserApiTest extends TestCase
{
    use RefreshDatabase; // Limpa o banco de dados antes e depois do teste

    public function test_deve_criar_um_novo_usuario_descarte()
    {
        // Dispara uma requisição POST simulando o Postman
        $response = $this->postJson('/api/users', [
            'name' => 'Usuário Teste',
            'email' => 'teste@reoleo.com',
            'password' => 'senha123',
            'role' => 'Usuario_Descarte',
            'address' => 'Rua Teste, 123'
        ]);

        // Verifica se a API retornou o status 201 (Created)
        $response->assertStatus(201);

        // Verifica se os dados realmente foram parar no banco de dados
        $this->assertDatabaseHas('users', [
            'email' => 'teste@reoleo.com',
            'role' => 'Usuario_Descarte'
        ]);
    }

    public function test_deve_listar_usuarios()
    {
        // Cria um usuário falso diretamente no banco
        User::create([
            'name' => 'Maria',
            'email' => 'maria@teste.com',
            'password' => bcrypt('senha123'),
            'role' => 'Empresa_Coleta'
        ]);

        // Faz um GET na rota
        $response = $this->getJson('/api/users');

        // Verifica se retornou 200 e se contém o email da Maria no JSON
        $response->assertStatus(200)
                 ->assertJsonFragment(['email' => 'maria@teste.com']);
    }
}