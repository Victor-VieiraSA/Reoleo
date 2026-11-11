<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'perfil' => [
                'type'       => 'ENUM',
                'constraint' => ['ponto_coleta', 'coletor_licenciado'],
                'default'    => 'ponto_coleta',
            ],
            'razao_social' => [
                'type'       => 'VARCHAR',
                'constraint' => 300,
            ],
            'cpf_cnpj' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'senha' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'endereco' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'numero' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'bairro' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'municipio' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'cep' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
            ],
            'referencia' => [
                'type'       => 'VARCHAR',
                'constraint' => 260,
                'null'       => true,
            ],
            'criado_em' => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');

        $this->forge->createTable('usuarios', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('usuarios', true);
    }
}
