<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;


class AddTelefoneToUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addColumn('usuarios', [
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'cpf_cnpj',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('usuarios', 'telefone');
    }
}
